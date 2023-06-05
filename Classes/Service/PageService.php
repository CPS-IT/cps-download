<?php
declare(strict_types=1);

namespace Cpsit\CpsDownload\Service;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PageService
{
    /**
     * Retrieves subpages of given pageIds recursively until reached $depth
     *
     * @param array $pages
     * @param int $depth
     * @return int[] an array with all pageIds
     */
    public function expandPagesWithSubPages(array $pages, int $depth = 0): array
    {
        $queryGenerator = GeneralUtility::makeInstance(QueryGenerator::class);
        $pidList = $pages;

        // iterate through root-page ids and merge to array
        foreach ($pages as $pid) {
            $result = $queryGenerator->getTreeList($pid, $depth, 0, 1);
            if ($result) {
                $subtreePids = explode(',', $result);
                $pidList = array_merge($pidList, $subtreePids);
            }
        }
        return GeneralUtility::intExplode(',', implode(',', $pidList));
    }

}
