<?php
declare(strict_types=1);

namespace Vierwd\VierwdLinkHandler;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Typolink\UnableToLinkException;

class StaticLinkBuilder extends \TYPO3\CMS\Frontend\Typolink\AbstractTypolinkBuilder {

	public function build(array &$linkDetails, string $linkText, string $target, array $conf): array {
		$TSFE = $this->getTypoScriptFrontendController();
		$pageTsConfig = $TSFE->getPagesTSconfig();
		$configurationKey = $linkDetails['identifier'] . '.';

		$linkHandlerConfiguration = $pageTsConfig['TCEMAIN.']['linkHandler.'];

		if (!isset($linkHandlerConfiguration['static.'])) {
			throw new UnableToLinkException(
				'Configuration how to link "' . $linkDetails['typoLinkParameter'] . '" was not found, so "' . $linkText . '" was not linked.',
				1520522265,
				null,
				$linkText
			);
		}

		$linkHandlerConfiguration = $linkHandlerConfiguration['static.']['configuration.']['links.'][$configurationKey];

		$typoLinkConfiguration = $conf;
		unset($typoLinkConfiguration['parameter'], $typoLinkConfiguration['parameter.']);
		ArrayUtility::mergeRecursiveWithOverrule($typoLinkConfiguration, $linkHandlerConfiguration['typolink.']);

		// Build the full link to the record
		$localContentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
		$localContentObjectRenderer->start([]);
		$localContentObjectRenderer->parameters = $this->contentObjectRenderer->parameters;
		$link = $localContentObjectRenderer->typoLink($linkText, $typoLinkConfiguration);

		$this->contentObjectRenderer->lastTypoLinkLD = $localContentObjectRenderer->lastTypoLinkLD;
		$this->contentObjectRenderer->lastTypoLinkUrl = $localContentObjectRenderer->lastTypoLinkUrl;
		$this->contentObjectRenderer->lastTypoLinkTarget = $localContentObjectRenderer->lastTypoLinkTarget;

		// nasty workaround so typolink stops putting a link together, there is a link already built
		throw new UnableToLinkException(
			'',
			1491130170,
			null,
			$link
		);
	}
}
