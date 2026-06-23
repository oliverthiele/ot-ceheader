<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$ll = 'LLL:EXT:ot_ceheader/Resources/Private/Language/locallang_db.xlf:';

$tempColumns = [
    'header_rte_enable' => [
        'exclude' => true,
        'label' => $ll . 'header_rte_enable',
        'onChange' => 'reload',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'default' => 0,
        ],
    ],
    'header_rte' => [
        'exclude' => true,
        'label' => $ll . 'header_rte',
        'displayCond' => [
            'OR' => [
                'FIELD:header_rte_enable:REQ:true',
                'USER:OliverThiele\OtCeheader\UserFunc\DisplayCondition->isContentBlock',
            ],
        ],
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
        'displayCond' => [
            'OR' => [
                'FIELD:header_rte_enable:REQ:true',
                'USER:OliverThiele\OtCeheader\UserFunc\DisplayCondition->isContentBlock',
            ],
        ],
        'config' => [
            'type' => 'input',
            'size' => 50,
            'max' => 80,
        ],
    ],
    'icon_identifier' => [
        'exclude' => true,
        'label' => $ll . 'icon_identifier',
        'displayCond' => [
            'OR' => [
                'FIELD:header_rte_enable:REQ:true',
                'USER:OliverThiele\OtCeheader\UserFunc\DisplayCondition->isContentBlock',
            ],
        ],
        'config' => [
            'type' => 'input',
            'renderType' => ExtensionManagementUtility::isLoaded('ot_iconselector')
                ? 'otIconSelector'
                : null,
            'size' => 30,
            'max' => 40,
            'eval' => 'trim',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'headers',
    '--linebreak--,header_rte_enable, --linebreak--,header_rte, --linebreak--,preheader, --linebreak--,icon_identifier',
    'after:header'
);
