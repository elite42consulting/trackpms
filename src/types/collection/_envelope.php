<?php

namespace elite42\trackpms\types;


use elite42\trackpms\types\_envelope\_links;
use JetBrains\PhpStorm\Pure;


abstract class _envelope {

	public _links $_links;

	public int    $page_count  = 1;

	public int    $page_size   = 25;

	public int    $total_items = 1;

	public int    $page        = 1;


	#[Pure]
	public function __construct() {
		$this->_links = new _links();
	}

}