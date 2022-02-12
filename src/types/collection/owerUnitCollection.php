<?php

namespace elite42\trackpms\types\collection;


use elite42\trackpms\types\collection\ownerUnit\_embedded;
use JetBrains\PhpStorm\Pure;


/**
 * @see https://developer.trackhs.com/reference/getownerunitscollection
 */
class owerUnitCollection
	extends
	_envelope {

	public _embedded $_embedded;


	#[Pure]
	public function __construct() {
		parent::__construct();
		$this->_embedded = new _embedded();
	}

}