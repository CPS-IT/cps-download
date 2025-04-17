<?php

namespace Cpsit\CpsDownload\Configuration\Plugin;

/*
 * This file is part of the cps_download project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsDownload\Configuration\SettingsInterface as SI;
use Cpsit\CpsDownload\Controller\DownloadController;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationInterface;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationTrait;
use Cpsit\CpsDownload\Configuration\Extension;
use DWenzel\T3extensionTools\Configuration\PluginRegistrationInterface;
use DWenzel\T3extensionTools\Configuration\PluginRegistrationTrait;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

/**
 * Class DownloadListPluginConfiguration
 * Provides configuration for the Download
 * Plugin signature: cpsdownload_listselected
 */
#[AutoconfigureTag('t3extensionTools.pluginConfiguration')]
#[AutoconfigureTag('t3extensionTools.pluginRegistration')]
class DownloadListSelectedPluginConfiguration implements PluginConfigurationInterface, PluginRegistrationInterface
{
    use PluginConfigurationTrait;
    use PluginRegistrationTrait;

    protected string $extensionName = Extension::KEY;
    protected string $pluginName = 'ListSelected';
    protected string $pluginTitle = 'LLL:EXT:cps_download/Resources/Private/Language/locallang_be.xlf:plugin.download.list_selected.title';
    protected string $pluginDescription = 'Plugin for Selected Downloads';
    protected string $pluginGroup = 'plugins';
    protected string $pluginType = ExtensionUtility::PLUGIN_TYPE_PLUGIN;
    protected string $pluginIcon = SI::ICON_IDENTIFIER_DOWNLOAD;
    protected string $flexForm = 'FILE:EXT:cps_download/Configuration/FlexForms/DownloadListSelectedPlugin.xml';
    protected array $controllerActions = [
        DownloadController::class => 'listSelected'
    ];
    protected array $nonCacheableControllerActions = [];
}
