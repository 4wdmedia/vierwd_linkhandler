<?php
declare(strict_types=1);

namespace Vierwd\VierwdLinkHandler;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Recordlist\Controller\AbstractLinkBrowserController;
use TYPO3\CMS\Recordlist\LinkHandler\AbstractLinkHandler as BaseLinkHandler;
use TYPO3\CMS\Recordlist\LinkHandler\LinkHandlerInterface;

abstract class AbstractLinkHandler extends BaseLinkHandler implements LinkHandlerInterface {

	/** @var array  */
	protected $configuration = [];

	/** @var array */
	protected $linkParts = [];

	public function initialize(AbstractLinkBrowserController $linkBrowser, $identifier, array $configuration) {
		parent::initialize($linkBrowser, $identifier, $configuration);
		$this->configuration = $configuration;

		$this->view->getRequest()->setControllerExtensionName('vierwd_linkhandler');
		$this->view->setTemplateRootPaths([GeneralUtility::getFileAbsFileName('EXT:vierwd_linkhandler/Resources/Private/Templates/LinkBrowser')]);
		$this->view->setPartialRootPaths([GeneralUtility::getFileAbsFileName('EXT:vierwd_linkhandler/Resources/Private/Partials/LinkBrowser')]);
		$this->view->setLayoutRootPaths([GeneralUtility::getFileAbsFileName('EXT:vierwd_linkhandler/Resources/Private/Layouts/LinkBrowser')]);
	}

	public function getBodyTagAttributes(): array {
		return [];
	}
}
