<?php
declare(strict_types=1);

namespace Cpsit\CpsDownload\Controller;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Service\PageService;
use Cpsit\CpsUtility\Traits\FeCacheTagsTrait;
use Cpsit\CpsDownload\Configuration\SettingsInterface as SI;
use Cpsit\CpsDownload\Domain\Model\Dto\DemandInterface;
use Cpsit\CpsDownload\Domain\Model\Dto\DownloadDemand;
use Cpsit\CpsDownload\Domain\Repository\DownloadRepository;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use Cpsit\CpsUtility\Utility\PageUtility;
use Cpsit\CpsUtility\Traits\ExtBaseTypoScriptStdWrapParserTrait;

/**
 * Class DownloadController
 */
class DownloadController extends ActionController
{
    use ExtBaseTypoScriptStdWrapParserTrait;
    use FeCacheTagsTrait;

    protected const RECURSIVE_DEPTH_DEFAULT = 0;

    /**
     * @var DownloadRepository|null
     */
    protected DownloadRepository $downloadRepository;

    public function __construct(DownloadRepository $repository = null)
    {
        $this->downloadRepository = $repository;
    }

    public function initializeAction(): void
    {
        $this->addCacheTags([SI::FE_CACHE_TAG_DOWNLOAD]);
        $this->settings = $this->parseTypoScriptStdWrap($this->settings);
    }

    protected function prepareView(): void
    {
        $this->view->assign('contentObjectData', $this->request->getAttribute('currentContentObject')->data);
        if (is_object($GLOBALS['TSFE'])) {
            $this->view->assign('pageData', $GLOBALS['TSFE']->page);
        }
    }

    public function listAction(): ResponseInterface
    {
        $demand = $this->createDemandFromSettings();

        $downloads = $this->downloadRepository->findDemanded($demand);

        $this->prepareView();

        $variables = [
            SI::VIEW_VAR_DOWNLOADS => $downloads,
        ];

        $this->view->assignMultiple(
            $variables
        );

        return $this->htmlResponse();
    }

    public function listSelectedAction(): ResponseInterface
    {
        /** @var DownloadDemand $demand */
        $demand = $this->createDemandFromSettings();

        $downloads = $this->downloadRepository->findByUidList($demand->getDownloadIds());

        $this->prepareView();

        $variables = [
            SI::VIEW_VAR_DOWNLOADS => $downloads,
        ];

        $this->view->assignMultiple(
            $variables
        );
        return $this->htmlResponse();
    }

    /**
     * @return DemandInterface
     */
    protected function createDemandFromSettings(): DemandInterface
    {
        $demand = new DownloadDemand();

        $demand->setPageIds($this->resolveStoragePage());

        if (!empty($this->settings['listSelectedDownloads'])) {
            $demand->setDownloadIds(GeneralUtility::intExplode(',', $this->settings['listSelectedDownloads']));
        }

        if (!empty($this->settings['authorIds'])) {
            $demand->setAuthorIds(GeneralUtility::trimExplode(',', $this->settings['authorIds']));
        }

        if (!empty($this->settings['categoriesList'])) {
            $categoriesList = GeneralUtility::intExplode(',', $this->settings['categoriesList']);
            $demand->setCategoryIds($categoriesList);
        }

        return $demand;
    }

    /**
     * Get records storage pages array
     *
     * @return int[]
     */
    protected function resolveStoragePage(): array
    {
        /** @var PageUtility $pageUtility */
        $pageUtility = GeneralUtility::makeInstance(PageUtility::class);
        $recursiveDepth = (int)($this->settings['recursion_depth'] ?? self::RECURSIVE_DEPTH_DEFAULT);
        return $pageUtility->resolveStoragePages($this->settings['listPid'], $recursiveDepth);
    }
}
