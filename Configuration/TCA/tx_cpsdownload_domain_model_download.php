<?php
defined('TYPO3') or die();

$tableName = \Cpsit\CpsDownload\Domain\Model\Download::TABLE_NAME;
$extensionKey = \Cpsit\CpsDownload\Configuration\Extension::KEY;
$ll = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . $tableName . '.title',
        'label' => 'title',
        'default_sortby' => 'sorting',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'transOrigPointerField' => 'l10n_parent',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'uid,title,teaser',
        'type' => 'type',
        'typeicon_column' => 'type',
        'typeicon_classes' => [
            'default' => \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_FILE_DOWNLOAD,
            '1' => \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_EXT_DOWNLOAD,
            '2' => \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_LINK_DOWNLOAD,
        ],
        'useColumnsForDefaultValues' => 'type',

    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => $tableName,
                'foreign_table_where' => 'AND ' . $tableName . '.uid=###CURRENT_PID### AND ' . $tableName . '.sys_language_uid = 0',
                'default' => 0,
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
            ],
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'tstamp' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'type' => [
            'exclude' => false,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype_formlabel',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $ll . $tableName . '.type.I.0',
                        'value' => 0,
                        'icon' => \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_FILE_DOWNLOAD
                    ],
                    [
                        'label' => $ll . $tableName . '.type.I.1',
                        'value' => 1,
                        'icon' => \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_EXT_DOWNLOAD
                    ],
                    [
                        'label' => $ll . $tableName . '.type.I.2',
                        'value' => 2,
                        'icon' => \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_LINK_DOWNLOAD
                    ],
                ],
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
                'size' => 1,
                'maxitems' => 1,
            ]
        ],

        'title' => [
            'exclude' => false,
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'required' => true,
            ]
        ],
        'teaser' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.teaser',
            'config' => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 5,
                'max' => 255,
                'enableRichtext' => false,
            ]
        ],
        'accessibility' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.accessibility',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ]
        ],

        'link' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.link',
            'config' => [
                'type' => 'link',
                'size' => 50,
                'appearance' => ['browserTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel']
            ]
        ],

        'file_ext' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.file_ext',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => '']
                ],
                'itemsProcFunc' => \Cpsit\CpsDownload\UserFunctions\SelectItemsProcFunctions::class . '->downloadFileExtensions',
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
                'size' => 1,
                'maxitems' => 1,
            ]
        ],

        'information_date' => [
            'exclude' => false,
            'label' => $ll . $tableName . '.information_date',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'required' => false,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'format' => 'date',
            ],
        ],

        'files' => [
            'label' => $ll . $tableName . '.files',
            'config' => [
                ### !!! Watch out for fieldName different from columnName
                'type' => 'file',
                'allowed' => implode(',', Cpsit\CpsDownload\Domain\Model\Download::ALLOWED_FILE_FILE_EXTENSIONS),
                'maxitems' => 1,
                'minitems' => 1,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference'
                ],
                // custom configuration for displaying fields in the overlay/reference table
                // behaves the same as the image field.
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                        ]
                    ],
                ],
            ]
        ],
        'size' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.size',
            'config' => [
                'type' => 'input',
                'cols' => 14,
                'eval' => 'trim',
                'max' => 10,
            ],
        ],
        'author' => [
            'label' => 'LLL:EXT:cps_author/Resources/Private/Language/locallang_db.xlf:tx_cpsauthor_domain_model_author.title',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_cpsauthor_domain_model_author',
                'maxitems' => 1,
                'minitems' => 0,
                'size' => 1,
                'default' => 0,
                'fieldControl' => [
                    'editPopup' => [
                        'disabled' => true,
                    ],
                    'addRecord' => [
                        'disabled' => true,
                    ],
                    'listModule' => [
                        'disabled' => true,
                    ],
                ],
                'suggestOptions' => [
                    'default' => [
                        'minimumCharacters' => 2,
                    ]
                ]
            ]
        ],
        'categories' => [
            'exclude' => false,
            'l10n_mode' => 'exclude',
            'label' => $ll . 'download.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'minitems' => 0,
                'maxitems' => 99,
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND {#sys_category}.{#sys_language_uid} IN (-1, 0)
                    ORDER BY sys_category.sorting',
                'MM' => 'sys_category_record_mm',
                'MM_opposite_field' => 'items',
                'MM_match_fields' => [
                    'fieldname' => 'categories',
                    'tablenames' => \Cpsit\CpsDownload\Domain\Model\Download::TABLE_NAME,
                ],
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'maxLevels' => 1,
                        'nonSelectableLevels' => '0',
                        'expandAll' => false
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general, type, title, teaser, author, accessibility, files, information_date,
                --div--;' . $ll . 'tab.categories, categories,
                --div--;' . $ll . 'tab.language, --palette--;;language,
                --div--;' . $ll . 'tab.access' . ', hidden, --palette--;;access
            ',
        ],
        '1' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general, type, title, teaser, author, accessibility, link, --palette--;;external_file_info,
                --div--;' . $ll . 'tab.categories, categories,
                --div--;' . $ll . 'tab.language, --palette--;;language,
                --div--;' . $ll . 'tab.access' . ', hidden, --palette--;;access
            ',
        ],
        '2' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general, type, title, teaser, author, accessibility, link,
                --div--;' . $ll . 'tab.categories, categories,
                --div--;' . $ll . 'tab.language, --palette--;;language,
                --div--;' . $ll . 'tab.access' . ', hidden, --palette--;;access
            ',
        ],
    ],
    'palettes' => [
        'external_file_info' => [
            'label' => $ll . 'palette.external_file_info',
            'showitem' => 'size, file_ext, --linebreak--, information_date',
        ],
        'language' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
        'access' => [
            'showitem' => 'starttime, endtime',
        ]
    ],
];
