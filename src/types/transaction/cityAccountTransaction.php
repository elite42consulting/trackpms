<?php

namespace elite42\trackpms\types\transaction;


class cityAccountTransaction
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $invoiceId = null;
	public ?int $folioId   = null;

}