<?php

namespace elite42\trackpms\types;

class charge
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id                   = null;
	public string                                    $template             = '';
	public string                                    $name                 = '';
	public string                                    $displayName          = '';
	public ?int                                      $itemId               = null;
	public bool                                      $applyUnitFaxes       = false;
	public string                                    $taxPolicyType        = '';
	public string                                    $postDate             = '';
	public string                                    $rateType             = '';
	public float                                     $amount               = 0;
	public string                                    $frequency            = '';
	public string                                    $displayAs            = '';
	public bool                                      $allowFeeEdit         = false;
	public bool                                      $allowFeeRemoval      = false;
	public bool                                      $excludeFromInsurance = false;
	public bool                                      $hasUnitPricing       = false;
	public bool                                      $chargeOwner          = false;
	public string                                    $type                 = '';
	public ?int                                      $maxNights            = null;
	public ?float                                    $maxQuantity          = null;
	public ?float                                    $defaultQuantity      = null;
	public ?float                                    $maximumAmount        = null;
	public ?float                                    $minimumAmount        = null;
	public bool                                      $isStacked            = false;
	public bool                                      $includeInSubtotal    = false;
	public bool                                      $splitWithOwner       = false;
	public ?float                                    $managementCommission = null;
	public ?int                                      $minStayLength        = null;
	public ?int                                      $maxStayLength        = null;
	public string                                    $feeType              = '';
	public ?\DateTimeImmutable                       $createdAt            = null;
	public string                                    $createdBy            = '';
	public ?\DateTimeImmutable                       $updatedAt            = null;
	public string                                    $updatedBy            = '';
	public bool                                      $isActive             = false;
	public bool                                      $includeAllRedTypes   = false;
	public array                                     $reservationTypeIds   = [];
	public ?int                                      $homeawayProduceCode  = null;
	public ?int                                      $airbnbProductCode    = null;
	public ?int                                      $marriotProductCode   = null;
	public bool                                      $irmEnabled           = false;
	public bool                                      $requireFunding       = false;
	public bool                                      $isDeferExempted      = false;
	public bool                                      $channelStackedFees   = false;
	public ?int                                      $dateGroupId          = null;
	public                                           $dateGroup            = null;
	public string                                    $dateRangeType        = 'none';
	public ?\DateTimeImmutable                       $startDate            = null;
	public ?\DateTimeImmutable                       $endDate              = null;
	public ?\elite42\trackpms\types\_envelope\_links $_links               = null;

}
