<?php

namespace Cpsit\CpsDownload\Configuration\Plugin;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Controller\DownloadController;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationInterface;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationTrait;
use Cpsit\CpsDownload\Configuration\Extension;

/**
 * Class DownloadListPluginConfiguration
 * Provides configuration for the Download
 */
class DownloadListPluginConfiguration implements PluginConfigurationInterface
{
    use PluginConfigurationTrait;

    static protected $pluginName = 'List';
    static protected $pluginSignature = 'cpsdownload_list';
    static protected $pluginTitle = 'LLL:EXT:cps_download/Resources/Private/Language/locallang_be.xlf:plugin.download.list.title';

    static protected $flexForm = 'FILE:EXT:cps_download/Configuration/FlexForms/DownloadListPlugin.xml';
    static protected $controllerActions = [
        DownloadController::class => 'list'
    ];

    static protected $nonCacheableControllerActions = [];
    static protected $vendorExtensionName = Extension::VENDOR_NAME . '.' . Extension::KEY;
}
