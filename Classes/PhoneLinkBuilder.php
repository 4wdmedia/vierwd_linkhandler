<?php
declare(strict_types=1);

namespace Vierwd\VierwdLinkHandler;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Typolink\UnableToLinkException;

class PhoneLinkBuilder extends \TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder {

	public function build(array &$linkDetails, string $linkText, string $target, array $conf): array {
		return [
			$linkDetails['typoLinkParameter'],
			$linkText,
			'', // target is always empty
		];
	}
}
