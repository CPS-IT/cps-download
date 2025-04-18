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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Annotation as Extbase;


class Category extends AbstractEntity
{
    /**
     * @var string
     */
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected $title = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * Downloads
     *
     * @var ObjectStorage<\Cpsit\CpsDownload\Domain\Model\Download>
     */
    #[Lazy]
    protected $downloads;

    /**
     * @var Category|null
     */
    #[Lazy]
    protected $parent;

    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all object storage properties
     */
    protected function initStorageObjects(): void
    {
        $this->downloads = new ObjectStorage();
    }

    /**
     * Gets the title.
     *
     * @return string the title, might be empty
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title the title to set, may be empty
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the description.
     *
     * @return string the description, might be empty
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description.
     *
     * @param string $description the description to set, may be empty
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return ObjectStorage
     */
    public function getDownloads(): ObjectStorage
    {
        return $this->downloads;
    }

    /**
     * @param ObjectStorage $downloads
     * @return Category
     */
    public function setDownloads(ObjectStorage $downloads): Category
    {
        $this->downloads = $downloads;
        return $this;
    }

    /**
     * Gets the parent category.
     *
     * @return Category|null the parent category
     */
    public function getParent()
    {
        if ($this->parent instanceof LazyLoadingProxy) {
            $this->parent->_loadRealInstance();
        }
        return $this->parent;
    }

    /**
     * Sets the parent category.
     *
     * @param Category $parent the parent category
     */
    public function setParent(Category $parent): void
    {
        $this->parent = $parent;
    }

}
