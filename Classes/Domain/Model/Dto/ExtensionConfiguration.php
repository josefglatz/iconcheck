<?php declare(strict_types = 1);

namespace JosefGlatz\Iconcheck\Domain\Model\Dto;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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

    public function __construct()
    {
        /** @noinspection UnserializeExploitsInspection */
        $settings = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['iconcheck']);
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
}
