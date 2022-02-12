<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/unitsdeltaapi-1
 */
class unitDelta {

	public \DateTimeImmutable $date;

	/** @var int[]  */
	public array $updated = [];

	/** @var int[]  */
	public array $removed = [];

	public function __construct() {
		$this->date = new \DateTimeImmutable();
	}

}