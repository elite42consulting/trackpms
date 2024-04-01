<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getreservation
 */
class reservation
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                                      $id                       = 0;

	public string                                                   $altConf                  = '';

	public int                                                      $unitId                   = 0;

	public ?\DateTimeImmutable                                      $arrivalDate              = null;

	public ?\DateTimeImmutable                                      $departureDate            = null;

    public ?\DateTimeImmutable                                      $fetchedDate              = null;

	public bool                                                     $earlyArrival             = false;

	public bool                                                     $lateDeparture            = false;

	public ?\DateTimeImmutable                                      $arrivalTime              = null;

	public ?\DateTimeImmutable                                      $departureTime            = null;

	public ?int                                                     $nights                   = null;

	/** @var string {Hold, Confirmed, Checked Out, Checked In, and Cancelled} */
	public string                                                   $status                   = '';

	public ?\DateTimeImmutable                                      $cancelledAt              = null;

	public array                                                    $occupants                = [
		1 => 0,
		2 => 0,
		3 => 0
	];

	public ?\elite42\trackpms\types\reservation\quoteBreakdown      $quoteBreakdown           = null;

	public ?\elite42\trackpms\types\reservation\folioBreakdown      $folioBreakdown           = null;

	public ?\elite42\trackpms\types\reservation\ownerBreakdown      $ownerBreakdown           = null;

	public ?\elite42\trackpms\types\reservation\typeInline          $typeInline               = null;

	public ?int                                                     $contactId                = null;

	public ?int                                                     $channelId                = null;

	public string                                                   $channel                  = '';

	public ?int                                                     $folioId                  = null;

	public ?int                                                     $guaranteePolicyId        = null;

	public string                                                   $subChannel               = '';

	public ?int                                                     $cancellationPolicyId     = null;

	public ?int                                                     $cancellationReasonId     = null;

	public string                                                   $cancellationReason       = '';

	public ?int                                                     $userId                   = null;

	public string                                                   $user                     = '';

	public ?int                                                     $travelAgentId            = null;

	public string                                                   $travelAgent              = '';

	public ?int                                                     $campaignId               = null;

	public string                                                   $campaign                 = '';

	public ?int                                                     $typeId                   = null;

	public ?int                                                     $rateTypeId               = null;

	public ?int                                                     $unitCodeId               = null;

	public ?int                                                     $cancelledById            = null;

	public string                                                   $cancelledBy              = '';

	public ?int                                                     $paymentMethodId          = null;

	public string                                                   $paymentMethod            = '';

	public ?int                                                     $groupId                  = null;

	public string                                                   $group                    = '';

	public ?\DateTimeImmutable                                      $holdExpiration           = null;

	public bool                                                     $isTaxable                = false;

	public string                                                   $inviteUuid               = '';

	public string                                                   $uuid                     = '';

	public string                                                   $source                   = '';

	public string                                                   $agreementStatus          = '';

	public bool                                                     $automatePayment          = false;

	public ?int                                                     $promoCodeId              = null;

	public string                                                   $promoCode                = '';

	public string                                                   $updatedBy                = '';

	public string                                                   $createdBy                = '';

	public float                                                    $requiredSecurityDeposit  = 0;

	public float                                                    $remainingSecurityDeposit = 0;

	public ?\DateTimeImmutable                                      $updatedAt                = null;

	public ?\DateTimeImmutable                                      $createdAt                = null;

	public ?\DateTimeImmutable                                      $bookedAt                = null;

	public ?\elite42\trackpms\types\reservation\reservationEmbedded $_embedded                = null;

	public ?\elite42\trackpms\types\_envelope\_links                $_links                   = null;

	protected function _afterJsonDeserialize() : void {
		$easternTimezone = new \DateTimeZone('America/New_York');

		if($this->arrivalDate instanceof \DateTimeInterface && $this->arrivalDate->getTimezone()->getName()!=$easternTimezone->getName()) {
			$this->arrivalDate = $this->arrivalDate->setTimezone( $easternTimezone );
		}

		if($this->arrivalTime instanceof \DateTimeInterface && $this->arrivalTime->getTimezone()->getName()!=$easternTimezone->getName()) {
			$this->arrivalTime = $this->arrivalTime->setTimezone( $easternTimezone );
		}

		if($this->departureDate instanceof \DateTimeInterface && $this->departureDate->getTimezone()->getName()!=$easternTimezone->getName()) {
			$this->departureDate = $this->departureDate->setTimezone( $easternTimezone );
		}

		if($this->departureTime instanceof \DateTimeInterface && $this->departureTime->getTimezone()->getName()!=$easternTimezone->getName()) {
			$this->departureTime = $this->departureTime->setTimezone( $easternTimezone );
		}

		if($this->bookedAt instanceof \DateTimeInterface && $this->bookedAt->getTimezone()->getName()!=$easternTimezone->getName()) {
			$this->bookedAt = $this->bookedAt->setTimezone( $easternTimezone );
		}
	}

	public function getArrivalDateTimeString(): string {
		$arrivalDateString = $this->arrivalDate?->format('n/j/Y') ?? '';
		$arrivalTimeString = $this->arrivalTime?->format('g:ia') ?? '';
		return trim( $arrivalDateString.' '.$arrivalTimeString );
	}
	public function getDepartureDateTimeString(): string {
		$departureDateString = $this->departureDate?->format('n/j/Y') ?? '';
		$departureTimeString = $this->departureTime?->format('g:ia') ?? '';
		return trim( $departureDateString.' '.$departureTimeString );
	}

	public function getBookedAtTimeString(): string {
		$bookedAtDateString = $this->bookedAt?->format('n/j/Y') ?? '';
		return trim( $bookedAtDateString );
	}
}
