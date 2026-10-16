<?php

declare(strict_types=1);

namespace Cpsit\CpsDownload\Tests\Functional\Configuration;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use PHPUnit\Framework\Attributes\DataProvider;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PluginRegistrationTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'cpsit/cps-utility',
        'cpsit/cps-author',
        'cpsit/cps-download',
    ];

    /**
     * @return array<string, array{string, string}>
     */
    public static function pluginProvider(): array
    {
        return [
            'list' => ['List', 'cpsdownload_list'],
            'listSelected' => ['ListSelected', 'cpsdownload_listselected'],
        ];
    }

    #[DataProvider('pluginProvider')]
    public function testPluginIsSelectableContentType(string $pluginName, string $signature): void
    {
        $item = $this->findCTypeItem($signature);

        self::assertNotNull($item);
        self::assertSame('plugins', $item['group']);
        self::assertNotEmpty($item['description']);
    }

    #[DataProvider('pluginProvider')]
    public function testPluginIsConfiguredAsContentElement(string $pluginName, string $signature): void
    {
        $plugin = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['CpsDownload']['plugins'][$pluginName] ?? null;

        self::assertIsArray($plugin);
        self::assertSame(ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT, $plugin['pluginType']);
        self::assertNotEmpty($plugin['controllers']);
    }

    public function testNoCpsDownloadListTypeIsRegistered(): void
    {
        $values = array_column($GLOBALS['TCA']['tt_content']['columns']['list_type']['config']['items'] ?? [], 'value');

        self::assertSame([], array_filter($values, static fn($value): bool => str_starts_with((string)$value, 'cpsdownload_')));
    }

    #[DataProvider('pluginProvider')]
    public function testPluginHasFlexFormDataStructure(string $pluginName, string $signature): void
    {
        $flexFormTools = $this->get(FlexFormTools::class);
        $identifier = $flexFormTools->getDataStructureIdentifier(
            $GLOBALS['TCA']['tt_content']['columns']['pi_flexform'],
            'tt_content',
            'pi_flexform',
            ['CType' => $signature, 'list_type' => '']
        );
        $dataStructure = $flexFormTools->parseDataStructureByIdentifier($identifier);

        self::assertNotEmpty($dataStructure['sheets']);
    }

    #[DataProvider('pluginProvider')]
    public function testConfigurationTabLabelIsTranslatable(string $pluginName, string $signature): void
    {
        self::assertStringContainsString(
            '--div--;LLL:EXT:cps_download/Resources/Private/Language/locallang_be.xlf:tab.configuration,pi_flexform',
            $GLOBALS['TCA']['tt_content']['types'][$signature]['showitem']
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function iconProvider(): array
    {
        return [
            'download' => ['cps-download'],
            'ext' => ['cps-ext-download'],
            'files' => ['cps-files-download'],
            'link' => ['cps-link-download'],
        ];
    }

    #[DataProvider('iconProvider')]
    public function testIconIsRegistered(string $identifier): void
    {
        self::assertTrue($this->get(IconRegistry::class)->isRegistered($identifier));
    }

    public function testTypoScriptKeysMatchTheRegisteredPlugins(): void
    {
        $setup = (string)file_get_contents(dirname(__DIR__, 3) . '/Configuration/TypoScript/setup.typoscript');
        $plugins = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['CpsDownload']['plugins'] ?? [];

        self::assertArrayHasKey('ListSelected', $plugins);
        self::assertStringContainsString('tx_cpsdownload {', $setup);
        self::assertStringContainsString('tx_cpsdownload_' . strtolower('ListSelected') . ' {', $setup);
        self::assertStringNotContainsString('list_type', $setup);
    }

    /**
     * @return array<string, array{string}>
     */
    public static function languageFileProvider(): array
    {
        return [
            'english' => ['locallang_be.xlf'],
            'german' => ['de.locallang_be.xlf'],
        ];
    }

    #[DataProvider('languageFileProvider')]
    public function testBackendLabelsOfPluginsExistInLanguageFile(string $fileName): void
    {
        $xml = simplexml_load_file(dirname(__DIR__, 3) . '/Resources/Private/Language/' . $fileName);
        self::assertInstanceOf(\SimpleXMLElement::class, $xml);
        $ids = [];
        foreach ($xml->xpath('//trans-unit') ?: [] as $unit) {
            $ids[] = (string)$unit['id'];
        }

        foreach (['plugin.download.list', 'plugin.download.list_selected'] as $prefix) {
            self::assertContains($prefix . '.title', $ids, $fileName);
            self::assertContains($prefix . '.description', $ids, $fileName);
        }
        self::assertContains('tab.configuration', $ids, $fileName);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function findCTypeItem(string $signature): ?array
    {
        foreach ($GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'] as $item) {
            if (($item['value'] ?? null) === $signature) {
                return $item;
            }
        }

        return null;
    }
}
