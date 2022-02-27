<?php

namespace elite42\trackpms\types;


class node
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $id = null;

	/** @var \elite42\trackpms\types\unit\unitRole[] */
	public array               $roles                = [];

	public array               $custom               = [];

	public ?\DateTimeImmutable $createdAt            = null;

	public string              $createdBy            = '';

	public ?\DateTimeImmutable $updatedAt            = null;

	public string              $updatedBy            = '';

	public string              $name                 = '';

	public ?int                $maxPets              = null;

	public ?int                $minimumAgeLimit      = null;

	public string              $phone                = '';

	public string              $websiteUrl           = '';

	public string              $streetAddress        = '';

	public string              $extendedAddress      = '';

	public string              $locality             = '';

	public string              $region               = '';

	public string              $postal               = '';

	public string              $country              = '';

	public ?int                $maxDiscount          = null;

	public string              $timezone             = '';

	public ?float              $longitude            = null;

	public ?float              $latitude             = null;

	public bool                $petFriendly          = false;

	public bool                $smokingAllowed       = false;

	public bool                $childrenAllowed      = false;

	public bool                $eventsAllowed        = false;

	public bool                $isAccessible         = false;

	public bool                $hasEarlyCheckin      = false;

	public bool                $hasLateCheckout      = false;

	public bool                $quickCheckin         = false;

	public bool                $quickCheckout        = false;

	public string              $checkinTime          = '';

	public string              $checkoutTime         = '';

	public string              $earlyCheckinTime     = '';

	public string              $lateCheckoutTime     = '';

	public ?int                $parentId             = null;

	public ?int                $typeId               = null;

	public ?int                $taxDistrictId        = null;

	public ?int                $localOfficeId        = null;

	public ?int                $cancellationPolicyId = null;

	public ?int                $housekeepingZoneId   = null;

	public ?int                $maintenanceZoneId    = null;

	//TODO: add array type
	public array $housekeepingNotes = [];

	/** @var int[] */
	public array $guaranteePoliciesIds = [];

	/** @var int[] */
	public array $documentsIds = [];

	/** @var int[] */
	public array $gatewaysIds = [];

	/** @var int[] */
	public array                                      $amenitiesIds = [];

	public ?\elite42\trackpms\types\node\nodeEmbedded $_embedded    = null;

	public ?\elite42\trackpms\types\_envelope\_links  $_links       = null;

}