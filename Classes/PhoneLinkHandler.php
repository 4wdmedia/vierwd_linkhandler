<?php
declare(strict_types=1);

namespace Vierwd\VierwdLinkHandler;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Link handler for phone-links
 */
class PhoneLinkHandler extends AbstractLinkHandler {

	/**
	 * We don't support updates since there is no difference to simply set the link again.
	 * @var bool
	 */
	protected $updateSupported = false;

	/**
	 * Checks if this is the handler for the given link
	 *
	 * The handler may store this information locally for later usage.
	 *
	 * @param array $linkParts Link parts as returned from TypoLinkCodecService
	 *
	 * @return bool
	 */
	public function canHandleLink(array $linkParts) {
		if (!isset($linkParts['url']['url'])) {
			return false;
		}

		if ($linkParts['type'] == 'phone' || ($linkParts['type'] === LinkService::TYPE_URL && substr($linkParts['url']['url'], 0, 6) === 'tel://')) {
			$linkParts['url']['type'] = 'phone';
			$linkParts['type'] = 'phone';
			$linkParts['phone'] = substr($linkParts['url']['url'], 6);
			$this->linkParts = $linkParts;
			return true;
		}

		return false;
	}

	/**
	 * Format the current link for HTML output
	 *
	 * @return string
	 */
	public function formatCurrentUrl() {
		return '';
	}

	/**
	 * Render the link handler
	 *
	 * @param ServerRequestInterface $request
	 *
	 * @return string
	 */
	public function render(ServerRequestInterface $request) {
		GeneralUtility::makeInstance(PageRenderer::class)->loadRequireJsModule('TYPO3/CMS/VierwdLinkhandler/PhoneLinkHandler');

		$this->view->assign('phonenumber', !empty($this->linkParts) ? $this->linkParts['phone'] : '');
		if (TYPO3_version >= '9.0.0') {
			$this->view->assign('label', 'LLL:EXT:recordlist/Resources/Private/Language/locallang_browse_links.xlf:setLink');
		} else {
			$this->view->assign('label', 'LLL:EXT:lang/Resources/Private/Language/locallang_browse_links.xlf:setLink');
		}
		return $this->view->render('Phone');
	}
}
