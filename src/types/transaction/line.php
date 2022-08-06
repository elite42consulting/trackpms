<?php

namespace elite42\trackpms\types\transaction;


class line
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id               = null;
	public string                                    $type             = '';
	public string                                    $description      = '';
	public ?int                                      $itemId           = null;
	public ?int                                      $accountId        = null;
	public string                                    $account          = '';
	public string                                    $unitAmount       = '';
	public ?float                                    $quantity         = null;
	public ?float                                    $netAmount        = null;
	public ?float                                    $taxAmount        = null;
	public ?float                                    $amount           = null;
	public ?int                                      $unitId           = null;
	public ?int                                      $remittanceBillId = null;
	public ?\elite42\trackpms\types\_envelope\_links $_links           = null;

}