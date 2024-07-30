<?php

namespace Cpsit\CpsDownload\Domain\Repository;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Doctrine\DBAL\Query\QueryBuilder;
use Cpsit\CpsDownload\Domain\Model\Dto\DemandInterface;
use Cpsit\CpsDownload\Domain\Model\Dto\DownloadDemand;
use Cpsit\CpsDownload\Domain\Model\Download;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class DownloadRepository extends Repository
{
    /**
     * Datamaper
     *
     * @var DataMapper
     */
    protected $dataMapper;

    public function __construct(\TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper $dataMapper)
    {
        parent::__construct();
        $this->dataMapper = $dataMapper;
    }

    protected $defaultOrderings = [
        Download::FIELD_SORTING => Query::ORDER_DESCENDING
    ];

    /**
     * @param DemandInterface $demand
     * @return QueryResultInterface
     */
    public function findDemanded(DemandInterface $demand): QueryResultInterface
    {
        $query = $this->createQuery();

        if ($demand instanceof DownloadDemand) {
            $this->applyConstraints($query, $demand);
        }

        return $query->execute();
    }

    /**
     * @param QueryInterface $query
     * @param DownloadDemand $demand
     */
    protected function applyConstraints(QueryInterface $query, DemandInterface $demand): void
    {
        $constraints = [];

        if (!empty($pages = $demand->getPageIds())) {
            $querySettings = $query->getQuerySettings();
            $querySettings->setRespectStoragePage(true)
                ->setStoragePageIds($pages);
            $query->setQuerySettings($querySettings);
        }


        if (!empty($categories = $demand->getCategoryIds())) {
            foreach ($categories as $category) {
                $categoryConstraint[] = $query->contains(Download::FIELD_CATEGORIES, $category);
            }
            $constraints[] = $query->logicalOr(...$categoryConstraint);
        }

        if (!empty($authors = $demand->getAuthorIds())) {
            $constraints[] = $query->in(Download::FIELD_AUTHOR, $authors);
        }

        if(!empty($constraints)){
            $query->matching(
                $query->logicalAnd(...$constraints)
            );
        }

    }

    /**
     * Returns all matching records for the given list of uids and applies the uidList sorting for the result
     *
     * @param int[] $uidList
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findByUidList(array $uidList): array
    {
        if (empty($uidList)) {
            return [];
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(Download::TABLE_NAME);

        $rows = $queryBuilder
            ->select('*')
            ->from(Download::TABLE_NAME)
            ->where($queryBuilder->expr()->in(Download::FIELD_UID, $uidList))
            ->add('orderBy',
                'FIELD(' . Download::TABLE_NAME . '.' . Download::FIELD_UID . ',' . implode(',', $uidList) . ')')
            ->execute()
            ->fetchAllAssociative();

        return $this->dataMapper->map(Download::class, $rows);
    }
}
