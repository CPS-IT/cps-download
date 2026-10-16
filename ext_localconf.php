<?php

defined('TYPO3') or die();

use Cpsit\CpsDownload\Controller\DownloadController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$plugins = [
    'List' => 'list',
    'ListSelected' => 'listSelected',
];

foreach ($plugins as $pluginName => $action) {
    ExtensionUtility::configurePlugin(
        'CpsDownload',
        $pluginName,
        [DownloadController::class => $action],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
}
