<?php

declare(strict_types=1);

$EM_CONF['ot_ceheader'] = [
    'title' => 'CE Header',
    'description' => 'Adds an optional RTE-based header field (header_rte) with preheader and icon support for tt_content headers.',
    'category' => 'frontend',
    'author' => 'Oliver Thiele',
    'author_email' => 'mail@oliver-thiele.de',
    'author_company' => 'Web Development Oliver Thiele',
    'state' => 'stable',
    'version' => '2.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-14.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
