<?php

namespace elite42\trackpms\types\transaction;


class ownerTransaction
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id               = null;
	public string $type             = '';
	public ?int   $folioId          = null;
	public ?int   $ownerId          = null;
	public ?int   $reservationFeeId = null;
	public ?int   $statementId      = null;

}