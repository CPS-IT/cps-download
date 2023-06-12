<?php
declare(strict_types=1);

namespace Cpsit\CpsDownload\Configuration;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

/**
 * Interface SettingsInterface
 */
interface SettingsInterface
{
    public const ICON_IDENTIFIER_DOWNLOAD = 'cps-download';
    public const ICON_IDENTIFIER_EXT_DOWNLOAD = 'cps-ext-download';
    public const ICON_IDENTIFIER_FILE_DOWNLOAD = 'cps-files-download';
    public const ICON_IDENTIFIER_LINK_DOWNLOAD = 'cps-link-download';

    public const FE_CACHE_TAG_DOWNLOAD = 'download';
    public const VIEW_VAR_DOWNLOADS = 'downloads';
}
