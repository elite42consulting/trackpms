<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getchannelunit
 */
class unit
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                                      $id                       = 0;

	public string                                                   $name                     = '';

	public ?int                                                     $maxPets                  = null;

	public string                                                   $shortName                = '';

	public string                                                   $shortDescription         = '';

	public string                                                   $longDescription          = '';

	public string                                                   $directions               = '';

	public string                                                   $checkinDetails           = '';

	public string                                                   $notes                    = '';

	public string                                                   $amenityDescription       = '';

	public ?int                                                     $minimumAgeLimit          = null;

	public string                                                   $phone                    = '';

	public string                                                   $websiteUrl               = '';

	public ?float                                                   $maxDiscount              = null;

	public string                                                   $area                     = '';

	public ?float                                                   $floors                   = null;

	public string                                                   $timezone                 = '';

	public string                                                   $housekeepingNotes        = '';

	public string                                                   $housekeepingStop         = '';

	public string                                                   $maintenanceStop          = '';

	public string                                                   $availabilityOrder        = '';

	public string                                                   $houseRules               = '';

	public ?int                                                     $nodeId                   = null;

	public ?int                                                     $typeId                   = null;

	public ?int                                                     $lodgingTypeId            = null;

	public string                                                   $streetAddress            = '';

	public string                                                   $extendedAddress          = '';

	public string                                                   $locality                 = '';

	public string                                                   $region                   = '';

	public string                                                   $postal                   = '';

	public string                                                   $country                  = '';

	public ?float                                                   $latitude                 = null;

	public ?float                                                   $longitude                = null;

	public ?int                                                     $maxOccupancy             = null;

	public ?int                                                     $bedrooms                 = null;

	public ?int                                                     $fullBathrooms            = null;

	public ?int                                                     $threeQuarterBathrooms    = null;

	public ?int                                                     $halfBathrooms            = null;

	public string                                                   $taxId                    = '';

	public ?int                                                     $taxDistrictId            = null;

	public ?int                                                     $systemId                 = null;

	public mixed                                                    $system                   = null;

	public ?int                                                     $travelInsuranceProductId = null;

	public ?\elite42\trackpms\types\unit\unitTravelInsuranceProduct $travelInsuranceProduct   = null;

	public ?int                                                     $cancellationPolicyId     = null;

	public ?int                                                     $localOfficeId            = null;

	public ?\elite42\trackpms\types\unit\unitLocalOffice            $localOffice              = null;

	public ?\DateTimeImmutable                                      $createdAt                = null;

	public string                                                   $createdBy                = '';

	public ?\DateTimeImmutable                                      $updatedAt                = null;

	public string                                                   $updatedBy                = '';

	public string                                                   $unitCode                 = '';

	public string                                                   $coverImage               = '';

	public ?int                                                     $cleanStatusId            = null;

	public string                                                   $maintenanceMessage       = '';

	public string                                                   $housekeepingMessage      = '';

	public bool                                                     $isActive                 = false;

	public bool                                                     $petFriendly              = false;

	public bool                                                     $smokingAllowed           = false;

	public bool                                                     $childrenAllowed          = false;

	public bool                                                     $eventsAllowed            = false;

	public bool                                                     $isAccessible             = false;

	public bool                                                     $hasEarlyCheckin          = false;

	public bool                                                     $hasLateCheckout          = false;

	public bool                                                     $quickCheckin             = false;

	public bool                                                     $quickCheckout            = false;

	public bool                                                     $useRoomConfiguration     = false;

	public bool                                                     $isBookable               = false;

	public bool                                                     $isLimited                = false;

	public bool                                                     $folioException           = false;

	public ?\DateTimeImmutable                                      $checkinTime              = null;

	public ?\DateTimeImmutable                                      $checkoutTime             = null;

	public ?\DateTimeImmutable                                      $earlyCheckinTime         = null;

	public ?\DateTimeImmutable                                      $lateCheckoutTime         = null;

	public float                                                    $securityDeposit          = 0;

	/** @var \elite42\trackpms\types\unit\unitRole[] */
	public array $roles = [];

	/** @var \elite42\trackpms\types\unit\unitComposite[] */
	public array                         $composites         = [];

	public ?int                          $unitTypeId         = null;

	public ?int                          $housekeepingZoneId = null;

	public ?\elite42\trackpms\types\zone $housekeepingZone   = null;

	public ?int                          $maintenanceZoneId  = null;

	public ?\elite42\trackpms\types\zone $maintenanceZone    = null;

	/** @var \elite42\trackpms\types\unit\unitBedType[] */
	public array $bedTypes = [];

	/** @var \elite42\trackpms\types\unit\unitRoom[] */
	public array                                      $rooms  = [];

	public ?\elite42\trackpms\types\unit\unitCustomFields $custom = null;

	/** @var int[] */
	public array $guaranteePoliciesIds = [];

	/** @var int[] */
	public array $amenitiesIds = [];

	/** @var int[] */
	public array $documentsIds = [];

	/** @var int[] */
	public array                                      $gatewaysIds = [];

	public ?\elite42\trackpms\types\unit\unitEmbedded $_embedded   = null;

	public ?\elite42\trackpms\types\_envelope\_links  $_links      = null;


	public function addressToString() {
		$addressParts = [];
		if( !empty( $this->streetAddress ) ) {
			$addressParts[] = $this->streetAddress;
		}
		if( !empty( $this->extendedAddress ) ) {
			$addressParts[] = $this->extendedAddress;
		}
		if( !empty( $this->locality ) ) {
			$addressParts[] = $this->locality;
		}
		if( !empty( $this->region ) || !empty( $this->postalCode ) ) {
			$stateZipParts = [];

			if( !empty( $this->region ) ) {
				$stateZipParts[] = $this->region;
			}
			if( !empty( $this->postalCode ) ) {
				$stateZipParts[] = $this->postalCode;
			}
			$addressParts[] = implode( ' ', $stateZipParts );
		}

		return implode( ', ', $addressParts );
	}

}