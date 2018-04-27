<?php
declare(strict_types=1);

namespace Vierwd\VierwdLinkHandler;

use TYPO3\CMS\Core\LinkHandling\LinkHandlingInterface;

/**
 * Link handler for arbitrary database records
 */
class StaticLinkResolver implements LinkHandlingInterface {

	/**
	 * Returns a string interpretation of the link href query from objects, something like
	 *
	 *  - t3://page?uid=23&my=value#cool
	 *  - https://www.typo3.org/
	 *  - t3://file?uid=13
	 *  - t3://folder?storage=2&identifier=/my/folder/
	 *  - mailto:mac@safe.com
	 *
	 * array of data -> string
	 *
	 * @param array $parameters
	 * @return string
	 */
	public function asString(array $parameters): string {
		return 't3://static?identifier=' . $parameters['identifier'];
	}

	/**
	 * Returns a array with data interpretation of the link href from parsed query parameters of urn
	 * representation.
	 *
	 * array of strings -> array of data
	 *
	 * @param array $data
	 * @return array
	 */
	public function resolveHandlerData(array $data): array {
		return [
			'type' => 'static',
			'identifier' => $data['identifier'],
		];
	}
}
