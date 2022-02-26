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

	public bool                                                     $earlyArrival             = false;

	public bool                                                     $lateDeparture            = false;

	public ?\DateTimeImmutable                                      $arrivalTime              = null;

	public ?\DateTimeImmutable                                      $departureTime            = null;

	public ?int                                                     $nights                   = null;

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

	public ?\elite42\trackpms\types\reservation\reservationEmbedded $_embedded                = null;

	public ?\elite42\trackpms\types\_envelope\_links                $_links                   = null;

}