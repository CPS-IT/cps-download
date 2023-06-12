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

use DWenzel\T3extensionTools\Configuration\ExtensionConfiguration;
use Cpsit\CpsDownload\Configuration\Plugin\DownloadListPluginConfiguration;
use Cpsit\CpsDownload\Configuration\Plugin\DownloadListSelectedPluginConfiguration;
use Cpsit\CpsDownload\Domain\Model\Download;
use Cpsit\CpsDownload\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Extension
 *
 * provides configuration for the extension cps_download
 */
final class Extension extends ExtensionConfiguration
{

    public const NAME = 'CpsDownload';
    public const KEY = 'cps_download';
    public const VENDOR_NAME = 'Cpsit';

    public const TABLES_ALLOWED_ON_STANDARD_PAGES = [
        Download::TABLE_NAME
    ];

    /**
     * SVG icons to register
     */
    protected const SVG_ICONS_TO_REGISTER = [
        SI::ICON_IDENTIFIER_DOWNLOAD => 'EXT:cps_download/Resources/Public/Icons/download.svg',
        SI::ICON_IDENTIFIER_FILE_DOWNLOAD => 'EXT:cps_download/Resources/Public/Icons/file-download.svg',
        SI::ICON_IDENTIFIER_EXT_DOWNLOAD => 'EXT:cps_download/Resources/Public/Icons/ext-download.svg',
        SI::ICON_IDENTIFIER_LINK_DOWNLOAD => 'EXT:cps_download/Resources/Public/Icons/link-download.svg',
    ];

    protected const PLUGINS_TO_REGISTER = [
        DownloadListPluginConfiguration::class,
        DownloadListSelectedPluginConfiguration::class
    ];

    /**
     * Array of strings to add as TSconfig content.
     * @var string[]
     */
    protected const ADD_PAGE_TSCONFIG = [
        "@import 'EXT:cps_download/Configuration/TSconfig/ContentElementWizard.tsconfig'"
    ];

    /**
     * Add page TSconfig content
     */
    public static function addPageTSconfig(): void
    {
        foreach (self::ADD_PAGE_TSCONFIG as $TSconfig) {
            ExtensionManagementUtility::addPageTSConfig($TSconfig);
        }
    }
}
