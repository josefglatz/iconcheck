<?php

use JosefGlatz\Iconcheck\Domain\Model\Dto\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class);

    // Register backend module if it is not disabled
    if (!$extConf->isDisableModule()) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'JosefGlatz.iconcheck',
            'help',
            'tx_iconcheck_m1',
            '',
            [
                'Iconcheck' => 'index'
            ],
            [
                'access' => $extConf->isEnableModuleForEverybody() ? 'user,group' : 'admin',
                'icon' => 'EXT:iconcheck/Resources/Public/Icons/module.svg',
                'labels' => 'LLL:EXT:iconcheck/Resources/Private/Language/locallang.xlf',
            ]
        );
    }

}
