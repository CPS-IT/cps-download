<?php
defined('TYPO3') or die();

$extensionKey = \Cpsit\CpsDownload\Configuration\Extension::KEY;
$ll = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_db.xlf:';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    \Cpsit\CpsDownload\Configuration\Extension::KEY,
    \Cpsit\CpsDownload\Domain\Model\Download::TABLE_NAME,
    'categories',
    [
        'exclude' => false,
        'label' => $ll . 'download.categories',
        'fieldConfiguration' => [
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
            'treeConfig' => [
                'appearance' => [
                    'maxLevels' => 1
                ]
            ]
        ],
        'position' => 'replace:categories'
    ]
);
