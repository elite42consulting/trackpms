<?php

namespace elite42\trackpms\types\unitPricing;

class fees
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	/** @var \elite42\trackpms\types\unitPricing\fee[] */
	public array $fees              = [];
	public ?int  $reservationTypeId = null;

}
