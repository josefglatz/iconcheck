<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Icon Check: show registered icons',
    'description' => 'Backend module for listing (all) registered icons within your TYPO3 instance. Useful for integrators/developers which making there TYPO3 backends bright and shiny.',
    'category' => 'be',
    'author' => 'Josef Glatz',
    'author_email' => 'jousch@gmail.com',
    'author_company' => 'josefglatz.at',
    'state' => 'stable',
    'version' => '2.1.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.7.17-9.5.99',
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
