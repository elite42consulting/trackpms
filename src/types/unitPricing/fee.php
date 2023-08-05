<?php

namespace elite42\trackpms\types\unitPricing;

class fee
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $id = null;

	public string $name       = '';
	public bool   $isRequired = false;

	public string $type      = '';
	public string $displayAs = '';
	public string $frequency = '';
	public ?int   $maxNights = null;
	public float  $value     = 0;

	public bool  $isTaxable       = false;
	public bool  $useRentTaxes    = false;
	public array $taxes           = [];
	public ?int  $defaultQuantity = null;
	public ?int  $maxQuantity     = null;
	public ?int  $maxAmount       = null;
	public ?int  $minAmount       = null;
	public ?int  $minStayLength   = null;

	public array $validDates = [];

}
