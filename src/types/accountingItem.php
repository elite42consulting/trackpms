<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getitemscollection
 */
class accountingItem
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                 $id               = 0;
	public string              $name             = '';
	public bool                $isActive         = false;
	public string              $taxPolicyId      = '';
	public bool                $isTaxable        = false;
	/** @var string[]  */
	public array              $itemCategories   = [];
	public string              $revenueAccountId = '';
	public ?float              $unitPrice        = null;
	public string              $description      = '';
	public ?\DateTimeImmutable $createdAt        = null;
	public string              $createdBy        = '';
	public ?\DateTimeImmutable $updatedAt        = null;
	public string              $updatedBy        = '';


	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}