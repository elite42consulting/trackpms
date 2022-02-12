<?php

namespace elite42\trackpms\types\_envelope;


use elite42\trackpms\types\_envelope\link\link;
use JetBrains\PhpStorm\Pure;


class _links {

	public link $self;

	public link $first;

	public link $last;

	public link $next;

	public link $prev;


	#[Pure]
	public function __construct() {
		$this->self  = new link();
		$this->first = new link();
		$this->last  = new link();
		$this->next  = new link();
		$this->prev  = new link();
	}

}