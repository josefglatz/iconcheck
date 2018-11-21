<?php declare(strict_types = 1);

namespace JosefGlatz\Iconcheck\Domain\Model\Dto;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ExtensionConfiguration
 * @package JosefGlatz\Iconcheck\Domain\Model\Dto
 *
 * @TODO If TYPO3 8 LTS support should be dropped: remove ExtensionConfiguration Dto
 */
class ExtensionConfiguration
{

    /** @var bool */
    protected $listAllIconIdentifiers;

    /** @var string */
    protected $listIconsWithPrefix;

    /** @var bool */
    protected $enableModuleForEverybody;

    /** @var bool */
    protected $disableModule;

    /** @var bool */
    protected $extensionSetupFinished = true;

    public function __construct()
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['iconcheck'] === null) {
            $settings = [
                'listAllIconIdentifiers' => true,
                'listIconsWithPrefix' => 'content',
                'enableModuleForEverybody' => true,
                'disableModule' => false,
                'extensionSetupFinished' => false,
            ];
        } else {
            /** @noinspection UnserializeExploitsInspection */
            $settings = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['iconcheck']);
        }

        foreach ($settings as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return bool
     */
    public function isListAllIconIdentifiers(): bool
    {
        return (bool)$this->listAllIconIdentifiers;
    }

    /**
     * @return array
     */
    public function getListIconsWithPrefix(): array
    {
        return GeneralUtility::trimExplode(',', $this->listIconsWithPrefix, true);
    }

    /**
     * @return bool
     */
    public function isEnableModuleForEverybody(): bool
    {
        return (bool)$this->enableModuleForEverybody;
    }

    /**
     * @return bool
     */
    public function isDisableModule(): bool
    {
        return (bool)$this->disableModule;
    }

    /**
     * @return bool
     */
    public function isExtensionSetupFinished(): bool
    {
        return $this->extensionSetupFinished;
    }
}
