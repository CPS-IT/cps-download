<?php
defined('TYPO3_MODE') or die();

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
        'cruser_id' => 'cruser_id',
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
    'interface' => [
        'showRecordFieldList' => 'cruser_id,pid,sys_language_uid,l10n_parent,l10n_diffsource, ' .
            'hidden,starttime,endtime,type,title,teaser,categories,accessibility,size,link,file,information_date',
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
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
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
            'exclude' => true,
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0,
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
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'all languages',
                        -1,
                        'flags-multiple',
                    ],
                ],
                'default' => 0,
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
                        $ll . $tableName . '.type.I.0',
                        0,
                        \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_FILE_DOWNLOAD
                    ],
                    [
                        $ll . $tableName . '.type.I.1',
                        1,
                        \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_EXT_DOWNLOAD
                    ],
                    [
                        $ll . $tableName . '.type.I.2',
                        2,
                        \Cpsit\CpsDownload\Configuration\SettingsInterface::ICON_IDENTIFIER_LINK_DOWNLOAD
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
                'eval' => 'required',
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
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ]
        ],

        'link' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.link',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => 50,
                'max' => 1024,
                'eval' => 'trim',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'title' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel',
                        ],
                    ],
                ],
                'softref' => 'typolink'
            ]
        ],

        'file_ext' => [
            'exclude' => true,
            'label' => $ll . $tableName . '.file_ext',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', '']
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
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'date,int',
                'default' => 0,
                'required' => false,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],

        'files' => [
            'label' => $ll . $tableName . '.files',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('files', [
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
            ],
                implode(',', Cpsit\CpsDownload\Domain\Model\Download::ALLOWED_FILE_FILE_EXTENSIONS)
            )
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
                'internal_type' => 'db',
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
        ]
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
