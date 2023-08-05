<?php

namespace elite42\trackpms\types;

class unitPricing
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public string $currency      = '';
	public array  $occupantTypes = [];
	public array  $rateTypes     = [];

	/** @var \elite42\trackpms\types\unitPricing\fees[] $fees */
	public array $fees = [];

	/** @var \elite42\trackpms\types\unitPricing\tax[] $taxes */
	public array $taxes = [];

}
