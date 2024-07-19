<?php
defined('TYPO3') or die();


$GLOBALS['TCA']['sys_category']['columns']['items']['config']['MM_oppositeUsage']['tx_cpsdownload_domain_model_download']
    = ['categories'];

$extensionKey = \Cpsit\CpsDownload\Configuration\Extension::KEY;
$ll = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_db.xlf:';

// Bidirectional relation to Downloads
$downloadsSysCategoryColumns = [
    'downloads' => [
        'exclude' => true,
        'label' => $ll . 'sys_category.tx_cpsdownloads',
        'config' => [
            'type' => 'group',
            'size' => 5,
            'allowed' => 'tx_cpsdownload_domain_model_download',
            'foreign_table' => 'tx_cpsdownload_domain_model_download',
            'MM' => 'sys_category_record_mm',
            'MM_match_fields' => [
                'fieldname' => 'categories',
                'tablenames' => 'tx_cpsdownload_domain_model_download',
            ],
            'maxitems' => 1000
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $downloadsSysCategoryColumns);
