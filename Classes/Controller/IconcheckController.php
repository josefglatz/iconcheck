<?php declare(strict_types = 1);

namespace JosefGlatz\Iconcheck\Controller;

use JosefGlatz\Iconcheck\Domain\Model\Dto\ExtensionConfiguration;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;


class IconcheckController extends ActionController
{

    /**
     * Backend Template Container.
     * Takes care of outer "docheader" and other stuff this module is embedded in.
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * BackendTemplateContainer
     *
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * @var string
     */
    protected $languageFilePrefix = 'LLL:EXT:iconcheck/Resources/Private/Language/locallang.xlf:';

    /**
     * Method is called before each action and sets up the doc header.
     *
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        parent::initializeView($view);

        // Early return for actions without valid view like tcaCreateAction or tcaDeleteAction
        if (!($this->view instanceof BackendTemplateView)) {
            return;
        }

        $this->view->assign('currentAction', $this->request->getControllerActionName());

        // Shortcut button
        $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
        $getVars = $this->request->getArguments();
        $extensionName = $this->request->getControllerExtensionName();
        $moduleName = $this->request->getPluginName();
        if (\count($getVars) === 0) {
            $modulePrefix = strtolower('tx_' . $extensionName . '_' . $moduleName);
            $getVars = array('id', 'M', $modulePrefix);
        }
        $shortcutButton = $buttonBar->makeShortcutButton()
            ->setModuleName($moduleName)
            ->setGetVariables($getVars);
        $buttonBar->addButton($shortcutButton);

        // Add javascript for the backend module
        $pageRenderer = $this->view->getModuleTemplate()->getPageRenderer();
        $pageRenderer->addRequireJsConfiguration(
        // To shim the non AMD/UMD compatible javascript library it is necessary
        // to add it to the requirejs.config({})
            [
                'shim' => [
                    'clipboardjs' => ['exports' => 'clipboardjs']
                ],
                'paths' => [
                    'clipboardjs' => PathUtility::getAbsoluteWebPath(
                        ExtensionManagementUtility::extPath(
                            'iconcheck',
                            'Resources/Public/JavaScript/clipboard.js-2.0.1/dist/'
                        ) . 'clipboard.min'
                    )
                ],
            ]
        );
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/Iconcheck/CopyToClipboard');
    }

    /**
     * Overview
     *
     * @throws \InvalidArgumentException
     */
    public function indexAction()
    {
        // Instantiate TYPO3 icon registry
        $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
        // Retrieve all registered icons from registry
        $iconsAll = $iconRegistry->getAllRegisteredIconIdentifiers();

        // Load extConf
        $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class);

        // Show all icon identifiers alphabetically if enabled
        if ($extConf->isListAllIconIdentifiers()) {
            $listAll = $iconsAll;
            natcasesort($listAll);
            $this->view->assign('allIcons', $listAll);
        }

        // Render userdefined icons in module
        if (!empty($extConf->getListIconsWithPrefix())) {
            $iconsToShow = [];
            foreach ($extConf->getListIconsWithPrefix() as $string) {
                foreach ($iconsAll as $key) {
                    if (strpos($key, $string) === 0) {
                        $iconsToShow[$string][] = $key;
                    }
                }
                // Sort icons (only if it is an array)
                if (is_array($iconsToShow[$string])) {
                    natcasesort($iconsToShow[$string]);
                }
            }
            $this->view->assign('iconsToShow', $iconsToShow);
        }

        // Render information if extension setup isn't finished yet
        // (occurs mostly if the extension was activated through composer only)
        if (!$extConf->isExtensionSetupFinished()) {
            $this->view->assign('setupWarning', true);
        }
    }
}
