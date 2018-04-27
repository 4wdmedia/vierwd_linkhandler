<?php
declare(strict_types=1);

namespace Vierwd\VierwdLinkHandler;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Link handler for pre-defined links
 */
class StaticLinkHandler extends AbstractLinkHandler {

	/** @var array */
	protected $linkParts = [];

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
		if ($linkParts['type'] !== 'static') {
			return false;
		}

		$linkParts['url']['type'] = $linkParts['type'];
		$this->linkParts = $linkParts;

		return true;
	}

	/**
	 * Format the current link for HTML output
	 *
	 * @return string
	 */
	public function formatCurrentUrl() {
		$currentLinkIdentifier = $this->linkParts['url']['identifier'];
		return $this->configuration['links.'][$currentLinkIdentifier . '.']['label'] ?: '';
	}

	/**
	 * Render the link handler
	 *
	 * @param ServerRequestInterface $request
	 *
	 * @return string
	 */
	public function render(ServerRequestInterface $request) {
		GeneralUtility::makeInstance(PageRenderer::class)->loadRequireJsModule('TYPO3/CMS/VierwdLinkhandler/StaticLinkHandler');

		$links = '<div class="element-browser-panel element-browser-main">';
		$links .= '<div class="element-browser-main-content">';
		$links .= '<div class="element-browser-body"><ul>';
		$currentLinkIdentifier = $this->linkParts['url']['identifier'];
		foreach ($this->configuration['links.'] as $identifier => $configuration) {
			$identifier = trim($identifier, '.');
			$label = $configuration['label'];
			$active = $identifier === $currentLinkIdentifier ? ' class="bg-success"' : '';
			$links .= '<li><a href="#"' . $active . ' data-static-linkhandler data-identifier="' . htmlspecialchars($identifier) . '">' . htmlspecialchars($label) . '</a></li>';
		}
		$links .= '</ul></div>';
		$links .= '</div>';
		$links .= '</div>';

		return $links;
	}

	/**
	 * @return string[] Array of body-tag attributes
	 */
	public function getBodyTagAttributes() {
		$attributes = [];
		if (!empty($this->linkParts)) {
			$attributes['data-current-link'] = GeneralUtility::makeInstance(LinkService::class)->asString($this->linkParts['url']);
		}

		return $attributes;
	}
}
