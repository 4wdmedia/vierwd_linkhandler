<?php

namespace Vierwd\VierwdLinkHandler\XClass\Core\LinkHandling;

class LinkService extends \TYPO3\CMS\Core\LinkHandling\LinkService {

	/**
	 * LinkService in TYPO3 uses external url handler for all urls with ://.
	 * We need to return another LinkHandler for tel:-links
	 */
	public function resolve(string $linkParameter): array {
		if (substr($linkParameter, 0, 6) === 'tel://' && $this->handlers['phone']) {
			$result = $this->handlers['phone']->resolveHandlerData(['url' => $linkParameter]);
			$result['type'] = 'phone';
			return $result;
		} else {
			return parent::resolve($linkParameter);
		}
	}

}
