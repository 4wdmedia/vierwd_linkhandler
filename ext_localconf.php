<?php
defined('TYPO3_MODE') || die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler']['static'] = 'Vierwd\\VierwdLinkHandler\\StaticLinkResolver';
$GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']['static'] = 'Vierwd\\VierwdLinkHandler\\StaticLinkBuilder';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['linkHandler']['phone'] = 'Vierwd\\VierwdLinkHandler\\PhoneLinkResolver';
$GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']['phone'] = 'Vierwd\\VierwdLinkHandler\\PhoneLinkBuilder';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:vierwd_linkhandler/Configuration/PageTSconfig/linkhandler.typoscript">');

// LinkService in TYPO3 uses external url handler for all urls with ://.
// We need to return another LinkHandler for tel:-links
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\LinkHandling\\LinkService'] = [
	'className' => 'Vierwd\\VierwdLinkHandler\\XClass\\Core\\LinkHandling\\LinkService',
];
