<?php

namespace elite42\trackpms\types\collection;


use elite42\trackpms\types\collection\unitImage\_embedded;
use JetBrains\PhpStorm\Pure;


class unitImageCollection
	extends
	_envelope {

	public _embedded $_embedded;


	#[Pure]
	public function __construct() {
		parent::__construct();
		$this->_embedded = new _embedded();
	}

}