<?php

namespace elite42\trackpms\types;


use andrewsauder\jsonDeserialize\attributes\excludeJsonDeserialize;


class taxDistrict
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id                = null;

	public bool   $isActive          = false;

	public string $name              = '';

	public ?int   $shortTermPolicyId = null;

	//public string $longTermPolicy = '';

	public ?int $longTermPolicyId = null;

	public bool $hasBreakpoint    = false;

	public ?int $breakpoint       = null;

	public ?int $salesTaxPolicyId = null;

	//public string $salesTaxPolicy = '';

	public bool                                      $taxMarkup      = false;

	public ?\DateTimeImmutable                       $createdAt      = null;

	public string                                    $createdBy      = '';

	public ?\DateTimeImmutable                       $updatedAt      = null;

	public string                                    $updatedBy      = '';

	public string                                    $longTermPolicy = '';

	public string                                    $salesTaxPolicy = '';

	#[excludeJsonDeserialize]
	public ?array                                     $_embedded      = null;

	public ?\elite42\trackpms\types\_envelope\_links $_links         = null;

}