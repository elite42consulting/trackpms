<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/ Undocumented method
 */
class reservationType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id                         = null;

	public string                                    $name                       = '';

	public string                                    $publicName                 = '';

	public string                                    $code                       = '';

	public string                                    $description                = '';

	public bool                                      $isActive                   = false;

	public bool                                      $isCommissionable           = false;

	public string                                    $typeColor                  = '';

	public bool                                      $chargeRates                = false;

	public string                                    $chargeRent                 = '';

	public string                                    $rentEarned                 = '';

	public bool                                      $requiresAgreement          = false;

	public bool                                      $requirePayment             = false;

	public ?int                                      $cleaningOptionsId          = null;

	public string                                    $realizeRates               = '';

	public bool                                      $sendPortalInvites          = false;

	public bool                                      $portalReservationBreakdown = false;

	public bool                                      $showFolioTransactions      = false;

	public bool                                      $isLocked                    = false;
	public bool                                      $isOwner                    = false;

	public                                           $scheduleType1              = null;

	public float                                     $schedulePercentage1        = 0;

	public                                           $scheduleType2              = null;

	public float                                     $schedulePercentage2        = 0;

	public bool                                      $ownerStay                  = false;

	public bool                                      $personalUse                = false;

	public bool                                      $autoSelect                 = false;

	public                                           $securityDepositType        = null;

	public bool                                      $deferDisbursement          = false;

	public ?\DateTimeImmutable                       $deferDisbursementDate      = null;

	public bool                                      $posDefaultAllow            = false;

	public                                           $posDefaultLimit            = null;

	public ?\DateTimeImmutable                       $createdAt                  = null;

	public string                                    $createdBy                  = '';

	public ?\DateTimeImmutable                       $updatedAt                  = null;

	public string                                    $updatedBy                  = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links                     = null;

}
