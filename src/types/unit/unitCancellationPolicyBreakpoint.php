<?php

namespace elite42\trackpms\types\unit;


class unitCancellationPolicyBreakpoint
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id             = null;

	public ?int   $rangeStart     = null;

	public ?int   $rangeEnd       = null;

	public bool   $nonRefundable  = false;

	public bool   $nonCancelable  = false;

	public ?int   $penaltyNights  = null;

	public ?float $penaltyPercent = null;

	public ?float $penaltyFlat    = null;

	public string $description    = '';

}