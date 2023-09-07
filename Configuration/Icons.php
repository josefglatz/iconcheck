<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'ext-iconcheck-module' => [
        'provider' => SvgIconProvider::class,
        'source'   => 'EXT:iconcheck/Resources/Public/Icons/module.svg',
    ],
];
