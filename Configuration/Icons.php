<?php

declare(strict_types=1);

use Cpsit\CpsDownload\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    SI::ICON_IDENTIFIER_DOWNLOAD => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_download/Resources/Public/Icons/download.svg',
    ],
    SI::ICON_IDENTIFIER_FILE_DOWNLOAD => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_download/Resources/Public/Icons/file-download.svg',
    ],
    SI::ICON_IDENTIFIER_EXT_DOWNLOAD => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_download/Resources/Public/Icons/ext-download.svg',
    ],
    SI::ICON_IDENTIFIER_LINK_DOWNLOAD => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_download/Resources/Public/Icons/link-download.svg',
    ],
];
