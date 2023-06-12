<?php

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsDownload\UserFunctions;

use Cpsit\CpsDownload\Domain\Model\Download;

class SelectItemsProcFunctions
{
    /**
     * Get allowed download file extensions
     *
     * @param array $params
     */
    public function downloadFileExtensions(&$params): void
    {
        foreach (Download::ALLOWED_FILE_FILE_EXTENSIONS as $fileExtension) {
            $params['items'][] = ['.' .$fileExtension, $fileExtension];
        }
    }
}
