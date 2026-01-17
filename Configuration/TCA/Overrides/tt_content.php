<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$ll = 'LLL:EXT:ot_ceheader/Resources/Private/Language/locallang_db.xlf:';

$tempColumns = [
    'icon_identifier' => [
        'exclude' => true,
        'label' => $ll . 'icon_identifier',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'max' => 40,
            'eval' => 'trim',
        ],
    ],
    'header_rte' => [
        'exclude' => true,
        'label' => $ll . 'header_rte',
        'config' => [
            'type' => 'text',
            'rows' => 4,
            'cols' => 50,
            'enableRichtext' => true,
            'richtextConfiguration' => 'header',
        ],
    ],
    'preheader' => [
        'exclude' => true,
        'label' => $ll . 'preheader',
        'config' => [
            'type' => 'input',
            'size' => 50,
            'max' => 80,
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'headers',
    'preheader, --linebreak--,',
    'before:header'
);
ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'headers',
    '--linebreak--,header_rte, --linebreak--,icon_identifier',
    'after:header'
);
