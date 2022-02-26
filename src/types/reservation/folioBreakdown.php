<?php

namespace elite42\trackpms\types\reservation;


class folioBreakdown
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public string $currency  = '';

	public float  $totalRent = 0;

	public float  $adr       = 0;

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\rate[] */
	public array $rates        = [];

	public float $totalFees    = 0;

	public float $totalCharges = 0;

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\fee[] */
	public array $fees       = [];

	public float $subTotal   = 0;

	public float $totalTaxes = 0;

	/** @var \elite42\trackpms\types\reservation\quoteBreakdown\tax[] */
	public array $taxes           = [];

	public float $total           = 0;

	public float $grandTotal      = 0;

	public float $payments        = 0;

	public float $transfers       = 0;

	public float $insurance       = 0;

	public float $balance         = 0;

	public float $rentFeeSubtotal = 0;

	public array $chargelist      = [];

}