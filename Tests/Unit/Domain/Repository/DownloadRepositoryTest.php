<?php

declare(strict_types=1);

namespace Cpsit\CpsDownload\Tests\Unit\Domain\Repository;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Domain\Repository\DownloadRepository;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;

class DownloadRepositoryTest extends TestCase
{
    public function testConstructorRequiresConnectionPoolAfterDataMapper(): void
    {
        $constructor = (new \ReflectionClass(DownloadRepository::class))->getConstructor();
        self::assertNotNull($constructor);
        $parameters = $constructor->getParameters();

        self::assertCount(2, $parameters);
        self::assertSame('dataMapper', $parameters[0]->getName());
        self::assertSame(DataMapper::class, (string)$parameters[0]->getType());
        self::assertSame('connectionPool', $parameters[1]->getName());
        self::assertSame(ConnectionPool::class, (string)$parameters[1]->getType());
        self::assertFalse($parameters[1]->isOptional());
        self::assertFalse($parameters[1]->allowsNull());
    }

    public function testClassDoesNotCreateConnectionPoolStatically(): void
    {
        $source = (string)file_get_contents((new \ReflectionClass(DownloadRepository::class))->getFileName());

        self::assertStringNotContainsString('makeInstance(ConnectionPool', $source);
        self::assertStringNotContainsString('PDO::', $source);
    }
}
