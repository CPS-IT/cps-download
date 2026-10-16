<?php

declare(strict_types=1);

namespace Cpsit\CpsDownload\Tests\Functional\Upgrade;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Upgrade\ListTypeToCTypeUpdate;
use PHPUnit\Framework\Attributes\DataProvider;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class ListTypeToCTypeUpdateTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = ['install'];

    protected array $testExtensionsToLoad = ['cpsit/cps-download', 'b13/container'];

    private ListTypeToCTypeUpdate $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new ListTypeToCTypeUpdate(GeneralUtility::makeInstance(ConnectionPool::class));
    }

    public function testMappingIsOneToOne(): void
    {
        $mapping = (new \ReflectionMethod($this->subject, 'getListTypeToCTypeMapping'))->invoke($this->subject);

        self::assertSame(
            [
                'cpsdownload_list' => 'cpsdownload_list',
                'cpsdownload_listselected' => 'cpsdownload_listselected',
            ],
            $mapping
        );
    }

    /**
     * @return array<string, array{int, string}>
     */
    public static function migratedContentProvider(): array
    {
        return [
            'list' => [1, 'cpsdownload_list'],
            'listSelected' => [2, 'cpsdownload_listselected'],
            'hidden' => [6, 'cpsdownload_listselected'],
            'deleted' => [7, 'cpsdownload_listselected'],
            // workspace rows (t3ver_wsid > 0) are migrated by the core base class, no own handling
            'workspace' => [10, 'cpsdownload_listselected'],
        ];
    }

    #[DataProvider('migratedContentProvider')]
    public function testContentRecordsAreMigrated(int $uid, string $expectedCType): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        self::assertTrue($this->subject->updateNecessary());
        self::assertTrue($this->subject->executeUpdate());

        $row = $this->fetchRow('tt_content', $uid);
        self::assertSame($expectedCType, $row['CType']);
        self::assertSame('', $row['list_type']);
    }

    public function testRecordInsideAContainerKeepsItsContainerRelation(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        $this->subject->executeUpdate();

        $row = $this->fetchRow('tt_content', 9);
        self::assertSame('cpsdownload_listselected', $row['CType']);
        self::assertSame('', $row['list_type']);
        self::assertSame(8, (int)$row['tx_container_parent']);
        self::assertSame(201, (int)$row['colPos']);
        self::assertSame('b13-2cols-with-header-container', $this->fetchRow('tt_content', 8)['CType']);
    }

    public function testOtherContentRecordsStayUntouched(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        $this->subject->executeUpdate();

        $other = $this->fetchRow('tt_content', 3);
        self::assertSame('list', $other['CType']);
        self::assertSame('other_plugin', $other['list_type']);
        self::assertSame('cpsdownload_list', $this->fetchRow('tt_content', 4)['CType']);
        self::assertSame('text', $this->fetchRow('tt_content', 5)['CType']);
    }

    public function testBackendGroupPermissionsAreMigrated(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        $this->subject->executeUpdate();

        $permissions = explode(',', $this->fetchRow('be_groups', 1)['explicit_allowdeny']);
        sort($permissions);
        self::assertSame(
            [
                'tt_content:CType:cpsdownload_list',
                'tt_content:CType:cpsdownload_listselected',
                'tt_content:CType:text',
                'tt_content:list_type:other_plugin',
            ],
            $permissions
        );
        self::assertSame('tt_content:CType:cpsdownload_list', $this->fetchRow('be_groups', 2)['explicit_allowdeny']);
    }

    public function testSecondRunChangesNothing(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');
        $this->subject->executeUpdate();
        $contentAfterFirstRun = $this->fetchAll('tt_content');
        $groupsAfterFirstRun = $this->fetchAll('be_groups');

        self::assertFalse($this->subject->updateNecessary());
        self::assertTrue($this->subject->executeUpdate());
        self::assertSame($contentAfterFirstRun, $this->fetchAll('tt_content'));
        self::assertSame($groupsAfterFirstRun, $this->fetchAll('be_groups'));
    }

    public function testLegacyGroupFormatSkipsPermissionsButMigratesContent(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCTypeLegacyGroup.csv');

        $this->subject->executeUpdate();

        self::assertSame('cpsdownload_list', $this->fetchRow('tt_content', 1)['CType']);
        self::assertSame('tt_content:list_type:cpsdownload_list:ALLOW', $this->fetchRow('be_groups', 1)['explicit_allowdeny']);
        self::assertSame('tt_content:list_type:cpsdownload_listselected', $this->fetchRow('be_groups', 2)['explicit_allowdeny']);
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchRow(string $table, int $uid): array
    {
        foreach ($this->fetchAll($table) as $row) {
            if ((int)$row['uid'] === $uid) {
                return $row;
            }
        }
        self::fail('Row ' . $uid . ' of ' . $table . ' not found');
    }

    /**
     * Reads every row, including hidden and deleted ones.
     *
     * @return list<array<string, mixed>>
     */
    private function fetchAll(string $table): array
    {
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable($table);
        $queryBuilder->getRestrictions()->removeAll();

        return $queryBuilder->select('*')->from($table)->orderBy('uid')->executeQuery()->fetchAllAssociative();
    }
}
