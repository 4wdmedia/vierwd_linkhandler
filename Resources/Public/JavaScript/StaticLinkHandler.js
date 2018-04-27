define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function($, LinkBrowser) {
	'use strict';

	/**
	 * @type {{currentLink: string, linkRecord: function, linkCurrent: function}}
	 */
	var StaticLinkHandler = {
		currentLink: '',

		/**
		 * @param {Event} event
		 */
		linkRecord: function(event) {
			event.preventDefault();

			var data = $(this).data();
			LinkBrowser.finalizeFunction('t3://static?identifier=' + data.identifier);
		},

		/**
		 * @param {Event} event
		 */
		linkCurrent: function(event) {
			event.preventDefault();

			LinkBrowser.finalizeFunction(StaticLinkHandler.currentLink);
		}
	};

	$(function() {
		StaticLinkHandler.currentLink = $('body').data('currentLink');

		$('[data-static-linkhandler]').on('click', StaticLinkHandler.linkRecord);
		$('input.t3js-linkCurrent').on('click', StaticLinkHandler.linkCurrent);
	});

	return StaticLinkHandler;
});
