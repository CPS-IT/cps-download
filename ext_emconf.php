<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'CPS Download',
    'description' => 'Downloads',
    'category' => 'fe',
    'state' => 'stable',
    'author' => 'CPS Gmbh',
    'author_email' => 'v.falcon@familie-redlich.de',
    'author_company' => 'CPS GmbH',
    'version' => '3.0.0',
    'constraints'
        => [
            'depends'
                => [
                    'typo3' => '13.4.0-13.4.99',
                ],
            'conflicts'
                => [
                ],
            'suggests'
                => [
                ],
        ],
];
