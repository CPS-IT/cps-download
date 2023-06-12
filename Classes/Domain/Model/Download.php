<?php
declare(strict_types=1);

namespace Cpsit\CpsDownload\Domain\Model;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Domain\Model\Author;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;

class Download extends AbstractDomainObject
{
    public const TABLE_NAME = 'tx_cpsdownload_domain_model_download';
    public const FIELD_UID = 'uid';
    public const FIELD_TYPE = 'type';
    public const FIELD_TITLE = 'title';
    public const FIELD_TEASER = 'teaser';
    public const FIELD_CATEGORIES = 'categories';
    public const FIELD_ACCESSIBILITY = 'accessibility';
    public const FIELD_SIZE = 'size';
    public const FIELD_LINK = 'link';
    public const FIELD_FILES = 'files';
    public const FIELD_SORTING = 'sorting';
    public const FIELD_FILE_EXT = 'file_ext';
    public const FIELD_AUTHOR = 'author';
    public const FIELD_INFORMATION_DATE = 'information_date';


    public const DOWNLOAD_TYPE = [
        'FILE' => 0,
        'EXTERNAL_FILE' => 1,
        'LINK' => 2,
    ];

    public const ALLOWED_FILE_FILE_EXTENSIONS = [
        'doc','docx','odt','rtf','txt','wps','csv','ppt','pptx','pdf','xls','xlsx','zip','7z','gz'
    ];

    protected int $type = 0;
    protected string $title = '';
    protected string $teaser = '';
    protected bool $accessibility = false;
    protected string $size = '';
    protected string $link = '';
    protected string $fileExt = '';
    protected int $informationDate = 0;

    /**
     * Author
     *
     * @var Author|null
     */
    protected ?Author $author = null;

    /**
     * Download files
     *
     * @var ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @Cascade remove
     * @Lazy
     */
    protected $files;

    /**
     * Categories
     *
     * @var ObjectStorage<\Cpsit\CpsDownload\Domain\Model\Category>
     * @Lazy
     */
    protected $categories;

    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all object storage properties
     */
    protected function initStorageObjects(): void
    {
        $this->categories = new ObjectStorage();
        $this->files = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Download
     */
    public function setTitle(string $title): Download
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns the answer
     * @return string
     */
    public function getTeaser(): string
    {
        return $this->teaser;
    }

    /**
     * Sets the answer
     *
     * @param string $teaser
     * @return Download
     */
    public function setTeaser(string $teaser): Download
    {
        $this->teaser = $teaser;
        return $this;
    }

    /**
     * @return Author|null
     */
    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    /**
     * @param Author|null $author
     */
    public function setAuthor(?Author $author): void
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isAccessibility(): bool
    {
        return $this->accessibility;
    }

    /**
     * @param bool $accessibility
     */
    public function setAccessibility(bool $accessibility): void
    {
        $this->accessibility = $accessibility;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getFiles(): ObjectStorage
    {
        return $this->files;
    }

    /**
     * @param ObjectStorage $files
     */
    public function setFiles(ObjectStorage $files): void
    {
        $this->files = $files;
    }

    /**
     * Adds a file
     *
     * @param FileReference $file
     * @return $this
     */
    public function addFile(FileReference $file): Download
    {
        if ($this->getFiles() === null) {
            $this->file = new ObjectStorage();
        }
        $this->files->attach($file);
        return $this;
    }

    /**
     * Removes a file
     *
     * @param FileReference $file
     * @return $this
     */
    public function removeFile(FileReference $file): Download
    {
        $this->files->detach($file);
        return $this;
    }

    /**
     * Returns categories
     *
     * @return ObjectStorage<Category>
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Sets categories
     *
     * @param ObjectStorage<Category> $categories
     * @return Download
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * Adds a category
     *
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category): Download
    {
        $this->categories->attach($category);
        return $this;
    }

    /**
     * Removes a category
     *
     * @param Category $category
     * @return $this
     */
    public function removeCategory(Category $category): Download
    {
        $this->categories->detach($category);
        return $this;
    }

    /**
     * @return string
     */
    public function getFileExt(): string
    {
        return $this->fileExt;
    }

    /**
     * @param string $fileExt
     */
    public function setFileExt(string $fileExt): void
    {
        $this->fileExt = $fileExt;
    }

    /**
     * @return int
     */
    public function getInformationDate(): int
    {
        return $this->informationDate;
    }


    /**
     * Get first category
     *
     * @return Category|null
     */
    public function getFirstCategory(): ?Category
    {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
            $categories->rewind();
            return $categories->current();
        } else {
            return null;
        }
    }

    /**
     * Get first category
     *
     * @return FileReference|null
     */
    public function getFirstFile(): ?FileReference
    {
        $files = $this->getFiles();
        if (!is_null($files)) {
            $files->rewind();
            return $files->current();
        } else {
            return null;
        }
    }
}
