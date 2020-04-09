<?php declare(strict_types = 1);

namespace JosefGlatz\Iconcheck\Domain\Model\Dto;

use JosefGlatz\Iconcheck\Service\VersionService;
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

    public function __construct()
    {
        if (VersionService::isVersion8()) {
            $settings = (array)unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['iconcheck'], [ false ]);
        }
        if (VersionService::isVersion9() || VersionService::isVersion10()) {
            $settings = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('iconcheck');
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
}
