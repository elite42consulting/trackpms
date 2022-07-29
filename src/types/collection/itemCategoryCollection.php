<?php

namespace elite42\trackpms\types\collection;


use elite42\trackpms\types\collection\itemCategory\_embedded;
use JetBrains\PhpStorm\Pure;


class itemCategoryCollection
	extends
	_envelope {

	public _embedded $_embedded;


	#[Pure]
	public function __construct() {
		parent::__construct();
		$this->_embedded = new _embedded();
	}

}