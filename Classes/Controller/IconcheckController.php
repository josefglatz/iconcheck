<?php declare(strict_types = 1);

namespace JosefGlatz\Iconcheck\Controller;

use JosefGlatz\Iconcheck\Domain\Model\Dto\ExtensionSettings;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;


class IconcheckController extends ActionController
{
    private ModuleTemplate $moduleTemplate;

    public function __construct(
        private readonly IconRegistry $iconRegistry,
        private readonly ModuleTemplateFactory $moduleTemplateFactory,
    ) {
    }

    /**
     * The main action of the extension
     */
    public function indexAction(): ResponseInterface
    {
        // Retrieve all registered icons from registry
        $allIcons = $this->iconRegistry->getAllRegisteredIconIdentifiers();

        // Load extConf
        $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('iconcheck') ?: [];;

        // Show all icon identifiers alphabetically if enabled
        if ($extConf['listAllIconIdentifiers'] ?? true) {
            $listAll = $allIcons;
            natcasesort($listAll);
            $this->view->assign('allIcons', $listAll);
        }

        // Render userdefined icons in module
        $iconsWithPrefixList = (string)($this->settings['listIconsWithPrefix'] ?? 'theme,content');
        $iconsWithPrefix = GeneralUtility::trimExplode(',', $iconsWithPrefixList, true);

        if ($iconsWithPrefix) {
            $iconsToShow = [];

            foreach ($iconsWithPrefix as $iconPrefix) {
                foreach ($allIcons as $icon) {
                    if (str_starts_with($icon, $iconPrefix)) {
                        if (empty($iconsToShow[$iconPrefix])) {
                            $iconsToShow[$iconPrefix] = [];
                        }

                        $iconsToShow[$iconPrefix][] = $icon;
                    }
                }

                // Sort icons (only if it is an array)
                if (isset($iconsToShow[$iconPrefix])) {
                    natcasesort($iconsToShow[$iconPrefix]);
                }
            }

            $this->view->assign('iconsToShow', $iconsToShow);
        }

        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());

        return $this->htmlResponse($moduleTemplate->renderContent());
    }
}
