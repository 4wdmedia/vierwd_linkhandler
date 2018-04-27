define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function($, LinkBrowser) {
	'use strict';

	var PhoneLinkHandler = {};

	/**
	 *
	 * @param {Event} event
	 */
	PhoneLinkHandler.link = function(event) {
		event.preventDefault();

		var value = $(this).find('[name="phonenumber"]').val().replace(/[^0-9+]/g, '');
		if (!value) {
			$(this).find('[name="phonenumber"]').val('');
			return;
		}

		LinkBrowser.finalizeFunction('tel://' + value);
	};

	$(function() {
		$('#phoneform').on('submit', PhoneLinkHandler.link);
	});

	return PhoneLinkHandler;
});
