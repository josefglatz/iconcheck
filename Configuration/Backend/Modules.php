<?php

declare(strict_types=1);

return [
    'iconcheck' => [
        'parent' => 'help',
        'access' => 'user,group',
        'path' => '/module/help/josefglatz/iconcheck',
        'iconIdentifier' => 'ext-iconcheck-module',
        'labels' => 'LLL:EXT:iconcheck/Resources/Private/Language/locallang.xlf',
        'extensionName' => 'Iconcheck',
        'controllerActions' => [
            \JosefGlatz\Iconcheck\Controller\IconcheckController::class => [
                'index',
            ],
        ],
    ],
];
