<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/getavailablereservationfees
 */
class availableFee
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $id = null;

	public ?int   $chargeId        = null;
	public string $type            = '';
	public string $rateType        = '';
	public string $name            = '';
	public string $displayAs       = '';
	public bool   $isOwner         = false;
	public ?int   $maxQuantity     = null;
	public string $postDate        = '';
	public float  $itemPrice       = 0;
	public float  $itemTax         = 0;
	public bool   $isTaxable       = false;
	public bool   $allowFeeRemoval = false;
	public bool   $allowFeeEdit    = false;

}
