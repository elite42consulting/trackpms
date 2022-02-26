<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getowner
 */
class owner
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                 $id                          = 0;

	public bool                $isActive                    = false;

	public string              $type                        = '';

	public string              $name                        = '';

	public string              $streetAddress               = '';

	public string              $extendedAddress             = '';

	public string              $locality                    = '';

	public string              $region                      = '';

	public string              $postal                      = '';

	public string              $country                     = '';

	public string              $taxType                     = '';

	public string              $taxName                     = '';

	public string              $taxId                       = '';

	public ?\DateTimeImmutable $achVerifiedAt               = null;

	public string              $achAccountType              = '';

	public string              $achAccountNumber            = '';

	public string              $achRoutingNumber            = '';

	public bool                $travelAgentDeductCommission = false;

	public float               $travelAgentCommission       = 0;

	public string              $travelAgentIataNumber       = '';

	public bool                $enableWorkOrderApproval     = false;

	public string              $notes                       = '';

	public string              $wcInsurancePolicy           = '';

	public ?\DateTimeImmutable $wcExpirationDate            = null;

	public string              $glInsurancePolicy           = '';

	public ?\DateTimeImmutable $glExpirationDate            = null;

	public string              $website                     = '';

	public string              $email                       = '';

	public string              $fax                         = '';

	public string              $phone                       = '';

	public string              $paymentType                 = '';

	/** @var \elite42\trackpms\types\owner\tag[] */
	public array                                     $tags                   = [];

	public string                                    $taxStreetAddress       = '';

	public string                                    $taxExtendedAddress     = '';

	public string                                    $taxLocality            = '';

	public string                                    $taxRegion              = '';

	public string                                    $taxPostalCode          = '';

	public string                                    $taxCountry             = '';

	public string                                    $taxPhone               = '';

	public ?int                                      $companyId              = null;

	public bool                                      $alwaysShowInStatements = false;

	public bool                                      $splitWithContacts      = false;

	public string                                    $agentCommission        = '';

	public float                                     $currentBalance         = 0;

	public float                                     $minimumBalance         = 0;

	public float                                     $openingBalance         = 0;

	public float                                     $deferredBalance        = 0;

	public float                                     $minDeferredTxnAmount   = 0;

	public ?\DateTimeImmutable                       $createdAt              = null;

	public string                                    $createdBy              = '';

	public ?\DateTimeImmutable                       $updatedAt              = null;

	public string                                    $updatedBy              = '';

	public int                                       $activeUnitCount        = 0;

	public ?\elite42\trackpms\types\_envelope\_links $_links                 = null;

}