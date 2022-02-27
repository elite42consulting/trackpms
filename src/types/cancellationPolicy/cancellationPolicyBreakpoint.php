<?php

namespace elite42\trackpms\types\cancellationPolicy;


class cancellationPolicyBreakpoint
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id             = null;

	public ?int   $rangeStart     = null;

	public ?int   $rangeEnd       = null;

	public bool   $nonRefundable  = false;

	public bool   $nonCancelable  = false;

	public ?int   $penaltyNights  = null;

	public float  $penaltyPercent = 0;

	public float  $penaltyFlat    = 0;

	public string $description    = '';

}