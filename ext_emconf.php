<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Icon Check: show registered icons',
    'description' => 'Module for listing (all) registered icons',
    'category' => 'be',
    'author' => 'Josef Glatz',
    'author_email' => 'jousch@gmail.com',
    'author_company' => '',
    'state' => 'stable',
    'version' => '2.0.1',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.7.17-9.3.99',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\Iconcheck\\' => 'Classes',
                ],
        ],
];
