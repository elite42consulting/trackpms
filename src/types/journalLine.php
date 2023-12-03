<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/getitemcateogires
 */
class journalLine
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int     $id;
	public int     $journal_id;
	public int     $account_id;
	public ?int    $tax_policy_id = null;
	public ?int    $item_id       = null;
	public ?int    $line_number   = null;
	public ?string $reconcile     = null;
	public ?string $description   = null;
	public ?float  $quantity      = null;
	public ?float  $unit_amount   = null;
	public ?float  $net_amount    = null;
	public ?float  $tax_amount    = null;
	public ?float  $amount        = null;
	public ?float  $markup        = null;
	public ?string $external_id   = null;

	public ?\DateTimeImmutable $createdAt = null;

	public string $createdBy = '';

	public ?\DateTimeImmutable $updatedAt = null;
	public string              $updatedBy = '';

	public ?\DateTimeImmutable $deletedAt = null;

	public ?int     $tax_id                   = null;
	public ?int     $unit_id                  = null;
	public ?int     $statement_id             = null;
	public ?bool    $tax_on_markup            = null;
	public ?int     $remittance_bill_id       = null;
	public ?bool    $is_tax_exempted          = null;
	public ?bool    $has_channel_remitted_tax = null;
	public ?float   $tax_rate                 = null;
	public ?journal $_journal                 = null;

}
