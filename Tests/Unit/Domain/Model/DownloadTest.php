<?php
declare(strict_types=1);

namespace Cpsit\CpsDownload\Tests\Unit\Configuration;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Domain\Model\Download;
use PHPUnit\Framework\TestCase;
use Cpsit\CpsDownload\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

class DownloadTest extends TestCase
{
    /**
     * @var Download
     */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = new Download();
    }

    public function testGetTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    public function testGetTeaserInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getTeaser()
        );
    }


    public function testTitleCanBeSet(): void
    {
        $download = 'foo';
        $this->subject->setTitle($download);
        self::assertSame(
            $download,
            $this->subject->getTitle()
        );
    }

    public function testCategoriesCanBeSet(): void
    {
        $category = new Category();
        $storage = new ObjectStorage();
        $storage->attach($category);

        $this->subject->setCategories($storage);

        self::assertSame(
            $storage,
            $this->subject->getCategories()
        );
    }

    public function testCategoryCanBeAdded(): void
    {
        $category = new Category();
        $this->subject->addCategory($category);
        $storage = $this->subject->getCategories();

        self::assertContains(
            $category,
            $storage
        );
    }

    public function testCategoryCanBeRemoved(): void
    {
        $category = new Category();
        $storage = new ObjectStorage();
        $storage->attach($category);

        $this->subject->setCategories($storage);
        $this->subject->removeCategory($category);

        self::assertNotContains(
            $category,
            $this->subject->getCategories()
        );
    }
}
