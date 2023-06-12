<?php

namespace Cpsit\CpsDownload\Domain\Model\Dto;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface;

class DownloadDemand implements DemandInterface
{
    public const DEFAULT_LIMIT = 10;

    /**
     * Page Ids to search for
     * @var int[]
     */
    protected array $pageIds = [];

    /**
     * Download Ids to search for
     * @var int[]
     */
    protected array $downloadIds = [];

    /**
     * Author Ids to search for
     * @var int[]
     */
    protected array $authorIds = [];

    /**
     * Category Ids to search for
     * @var int[]
     */
    protected array $categoryIds = [];

    /**
     * @var int
     */
    protected int $limit = self::DEFAULT_LIMIT;

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return DownloadDemand
     */
    public function setLimit(int $limit): DownloadDemand
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getPageIds(): array
    {
        return $this->pageIds;
    }

    /**
     * @param int[] $pages
     * @return DownloadDemand
     */
    public function setPageIds(array $pages): DownloadDemand
    {
        $this->pageIds = $pages;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getDownloadIds(): array
    {
        return $this->downloadIds;
    }

    /**
     * @return int[]
     */
    public function getAuthorIds(): array
    {
        return $this->authorIds;
    }

    /**
     * @param int[] $authorIds
     */
    public function setAuthorIds(array $authorIds): void
    {
        $this->authorIds = $authorIds;
    }

    /**
     * @param int[] $downloadIds
     */
    public function setDownloadIds(array $downloadIds): DownloadDemand
    {
        $this->downloadIds = $downloadIds;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @param int[] $categoryIds
     */
    public function setCategoryIds(array $categoryIds): DownloadDemand
    {
        $this->categoryIds = $categoryIds;
        return $this;
    }

    /**
     * Get first category
     *
     * @return DomainObjectInterface|null
     */
    public function getFirstCategory(): ?DomainObjectInterface
    {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
            $categories->rewind();
            return $categories->current();
        } else {
            return null;
        }
    }

}
