<?php

namespace elite42\trackpms\types\reservation;


class quoteBreakdown
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public string $currency          = '';

	public float  $totalRent         = 0;

	public float  $adr               = 0;

	public float  $discount          = 0;

	public float  $totalFees         = 0;

	public float  $subTotal          = 0;

	public float  $totalTaxes        = 0;

	public float  $total             = 0;

	public float  $insurance         = 0;

	public float  $grandTotal        = 0;

	public float  $payments          = 0;

	public float  $balance           = 0;

	public float  $folioCharges      = 0;

	public float  $guestFees         = 0;

	public float  $guestRentFees     = 0;

	public float  $guestItemizedFees = 0;

	public float  $guestServiceFees  = 0;

	public float  $guestTaxFees      = 0;

	public float  $guestTotalRent    = 0;

	public float  $additionalRent    = 0;

	public float  $grossRent         = 0;

	public float  $guestGrossRent    = 0;

	public float  $actualAdr         = 0;

	public float  $guestAdr          = 0;

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\rate[] */
	public array $rates = [];

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\extraRate[] */
	public array $extraRates = [];

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\fee[] */
	public array $fees = [];

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\tax[] */
	public array $taxes   = [];

	public array $charges = [];

}