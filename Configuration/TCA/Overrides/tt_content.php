<?php

defined('TYPO3') or die();

use Cpsit\CpsDownload\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$languageFile = 'LLL:EXT:cps_download/Resources/Private/Language/locallang_be.xlf:';

$plugins = [
    'List' => ['plugin.download.list', 'DownloadListPlugin.xml'],
    'ListSelected' => ['plugin.download.list_selected', 'DownloadListSelectedPlugin.xml'],
];

foreach ($plugins as $pluginName => [$labelKey, $flexForm]) {
    $signature = ExtensionUtility::registerPlugin(
        'CpsDownload',
        $pluginName,
        $languageFile . $labelKey . '.title',
        SI::ICON_IDENTIFIER_DOWNLOAD,
        'plugins',
        $languageFile . $labelKey . '.description'
    );

    ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;' . $languageFile . 'tab.configuration,pi_flexform,', $signature, 'after:subheader');
    ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:cps_download/Configuration/FlexForms/' . $flexForm, $signature);
}
