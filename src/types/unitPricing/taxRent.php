<?php

namespace elite42\trackpms\types\unitPricing;

class taxRent
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?float $breakpoint = null;

	public bool $shortTerm = false;

	public bool $longTerm = false;

}
