<?php
defined('TYPO3_MODE') or die();

/**
 * Configure the backend module based on the extension configuration
 */
if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) >= 9000000) {
    // @TODO If TYPO3 8 LTS support should be dropped: remove version check
    $extConfIconcheck = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class);
    $isDisableModule = $extConfIconcheck->get('iconcheck', 'disableModule');
    $isEnableModuleForEverybody = $extConfIconcheck->get('iconcheck', 'enableModuleForEverybody');
} else {
    $extConfIconcheck = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \JosefGlatz\Iconcheck\Domain\Model\Dto\ExtensionConfiguration::class);
    $isDisableModule = $extConfIconcheck->isDisableModule();
    $isEnableModuleForEverybody = $extConfIconcheck->isEnableModuleForEverybody();
}

// Register backend module if it is not disabled
if (!$isDisableModule) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'JosefGlatz.iconcheck',
        'help',
        'tx_iconcheck_m1',
        '',
        [
            'Iconcheck' => 'index'
        ],
        [
            'access' => $isEnableModuleForEverybody ? 'user,group' : 'admin',
            'icon' => 'EXT:iconcheck/Resources/Public/Icons/module.svg',
            'labels' => 'LLL:EXT:iconcheck/Resources/Private/Language/locallang.xlf',
        ]
    );
}
unset($extConfIconcheck, $isDisableModule, $isEnableModuleForEverybody);
