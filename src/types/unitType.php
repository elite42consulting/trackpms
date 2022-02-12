<?php

namespace elite42\trackpms\types;


use JetBrains\PhpStorm\Pure;


class unitType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int  $id       = 0;

	public bool $isActive = false;

	/** @var \elite42\trackpms\types\unit\unitBedType[] */
	public array                                             $bedTypes  = [];

	public array                                             $custom    = [];

	public ?\elite42\trackpms\types\unitType\unitTypeUpdated $updated   = null;

	public ?\DateTimeImmutable                               $createdAt = null;

	public string                                            $createdBy = '';

	public ?\DateTimeImmutable                               $updatedAt = null;

	public string                                            $updatedBy = '';

	public string              $name                     = '';

	public ?int                $maxPets                  = null;

	public ?int                $minimumAgeLimit          = null;

	public ?float              $maxDiscount              = null;

	public string              $area                     = '';

	public string              $websiteUrl               = '';

	public ?float              $floors                   = null;

	public ?int                $maxOccupancy             = null;

	public ?int                $bedrooms                 = null;

	public ?int                $fullBathrooms            = null;

	public ?int                $threeQuarterBathrooms    = null;

	public ?int                $halfBathrooms            = null;

	public string              $timezone                 = '';

	public string              $maintenanceMessage       = '';

	public string              $housekeepingMessage      = '';

	public string              $housekeepingNotes        = '';

	public ?int                $oversellLimit            = null;

	public ?float              $securityDeposit          = null;

	public bool                $petFriendly              = false;

	public bool                $smokingAllowed           = false;

	public bool                $childrenAllowed          = false;

	public bool                $eventsAllowed            = false;

	public bool                $isAccessible             = false;

	public bool                $hasEarlyCheckin          = false;

	public bool                $hasLateCheckout          = false;

	public bool                $quickCheckin             = false;

	public bool                $quickCheckout            = false;

	public bool                $useRoomConfiguration     = false;

	public bool                $isBookable               = false;

	public bool                $allowUnitRates           = false;

	public bool                $allowOversell            = false;

	public ?\DateTimeImmutable $checkinTime              = null;

	public ?\DateTimeImmutable $checkoutTime             = null;

	public ?\DateTimeImmutable $earlyCheckinTime         = null;

	public ?\DateTimeImmutable $lateCheckoutTime         = null;

	public ?int                $lodgingTypeId            = null;

	public ?int                $cancellationPolicyId     = null;

	public ?int                $calendarGroupId          = null;

	public ?int                $housekeepingZoneId       = null;

	public ?int                $maintenanceZoneId        = null;

	public ?int                $travelInsuranceProductId = null;

	/** @var int[] */
	public array $guaranteePoliciesIds = [];

	/** @var int[] */
	public array $amenitiesIds = [];

	/** @var int[] */
	public array $documentsIds = [];

	/** @var int[] */
	public array                                              $gatewaysIds = [];

	public ?\elite42\trackpms\types\unitType\unitTypeEmbedded $_embedded   = null;

	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}
