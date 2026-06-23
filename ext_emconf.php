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
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '14.3.0-14.99.99',
            'php' => '8.4.0-8.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
