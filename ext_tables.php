<?php
defined('TYPO3_MODE') or die();

/**
 * Configure the backend module based on the extension configuration
 *
 * @TODO If TYPO3 9.5 LTS support should be dropped: only use Typo3Version class instead of TYPO3_version constant
 * @TODO If TYPO3 8 LTS support should be dropped: remove TYPO3 version check for ExtensionConfiguration
 */
$typo3Version = class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)
    ? (new \TYPO3\CMS\Core\Information\Typo3Version())->getVersion()
    : TYPO3_version;

if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger($typo3Version) >= 9000000) {
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

if (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger($typo3Version) >= 11000000) {
    $controller = \JosefGlatz\Iconcheck\Controller\IconcheckController::class;
} else {
    $controller = 'Iconcheck';
}

// Register backend module if it is not disabled
if (!$isDisableModule) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'JosefGlatz.iconcheck',
        'help',
        'tx_iconcheck_m1',
        '',
        [
            $controller => 'index'
        ],
        [
            'access' => $isEnableModuleForEverybody ? 'user,group' : 'admin',
            'icon' => 'EXT:iconcheck/Resources/Public/Icons/module.svg',
            'labels' => 'LLL:EXT:iconcheck/Resources/Private/Language/locallang.xlf',
        ]
    );
}
unset($extConfIconcheck, $isDisableModule, $isEnableModuleForEverybody, $typo3Version);
