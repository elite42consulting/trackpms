<?php

namespace elite42\trackpms\types;


class contract
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id                  = null;

	public string $code                = '';

	public string $name                = '';

	public string $type                = '';

	public string $description         = '';

	public bool   $isActive            = false;

	public bool   $hasPaymentFee       = false;

	public float  $paymentFee          = 0;

	public bool   $minLosOwnerOverride = false;

	public string $overrideType        = '';

	public float  $defaultMarkup       = 0;

	public float  $maximumMarkup       = 0;

	public float  $defaultCommission   = 0;

	/** @var \elite42\trackpms\types\contract\commissionValue[] */
	public array $commissionValues = [];

	//TODO: add array type
	public array                                     $items     = [];

	public ?\DateTimeImmutable                       $createdAt = null;

	public string                                    $createdBy = '';

	public ?\DateTimeImmutable                       $updatedAt = null;

	public string                                    $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links    = null;

}