<?php

namespace elite42\trackpms\types\transaction;


class folioTransaction
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id               = null;
	public string $type             = '';
	public ?int   $folioId          = null;
	public ?int   $roomNight        = null;
	public ?int   $nights           = null;
	public ?int   $chargeId         = null;
	public ?int   $reservationFeeId = null;
	public bool   $isManual         = false;

}