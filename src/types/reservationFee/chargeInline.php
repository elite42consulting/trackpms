<?php

namespace elite42\trackpms\types\reservationFee;


class chargeInline
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id              = null;

	public string $name            = '';

	public string $displayName     = '';

	public bool   $allowFeeRemoval = false;

	public string $realizedAt      = '';

}