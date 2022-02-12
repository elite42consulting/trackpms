<?php

namespace elite42\trackpms\types\unit;


class unitTravelInsuranceProduct
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                $id                        = null;

	public string              $name                      = '';

	public string              $provider                  = '';

	public bool                $enableReporting           = false;

	public bool                $irmEnabled                = false;

	public float               $percent                   = 0;

	public float               $split                     = 0;

	public float               $optOutWindow              = 0;

	public string              $termsAndConditions        = '';

	public string              $declineMessage            = '';

	public string              $revenueAccountId          = '';

	public string              $payableAccountId          = '';

	public bool                $selectedByDefault         = false;

	public bool                $allowCancelOverride       = false;

	public bool                $realizeAfterWindow        = false;

	public string              $apiKey                    = '';

	public string              $productClass              = '';

	public string              $producerCode              = '';

	public bool                $allowExternalNotification = false;

	public string              $insuranceType             = '';

	public bool                $isActive                  = false;

	public ?\DateTimeImmutable $createdAt                 = null;

	public string              $createdBy                 = '';

	public ?\DateTimeImmutable $updatedAt                 = null;

	public string              $updatedBy                 = '';

}