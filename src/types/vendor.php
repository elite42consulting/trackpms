<?php

namespace elite42\trackpms\types;


class vendor
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id                      = 0;

	public bool                                      $isActive                = false;

	public string                                    $type                    = '';

	public string                                    $name                    = '';

	public string                                    $streetAddress           = '';

	public string                                    $extendedAddress         = '';

	public string                                    $locality                = '';

	public string                                    $region                  = '';

	public string                                    $postal                  = '';

	public string                                    $country                 = '';

	public string                                    $phone                   = '';

	public string                                    $fax                     = '';

	public string                                    $email                   = '';

	public string                                    $website                 = '';

	public string                                    $notes                   = '';

	public string                                    $wcInsurancePolicy       = '';

	public ?\DateTimeImmutable                       $wcExpirationDate        = null;

	public string                                    $glInsurancePolicy       = '';

	public ?\DateTimeImmutable                       $glExpirationDate        = null;

	public bool                                      $enableWorkOrderApproval = false;

	public string                                    $paymentType             = '';

	public string                                    $achAccountType          = '';

	public string                                    $achRoutingNumber        = '';

	public string                                    $achAccountNumber        = '';

	public ?\DateTimeImmutable                       $achVerifiedAt           = null;

	public string                                    $taxId                   = '';

	public string                                    $taxName                 = '';

	public string                                    $taxType                 = '';

	public ?\DateTimeImmutable                       $createdAt               = null;

	public string                                    $createdBy               = '';

	public ?\DateTimeImmutable                       $updatedAt               = null;

	public string                                    $updatedBy               = '';

	//TODO: add array type
	public array                                     $tags                    = [];

	public ?\elite42\trackpms\types\_envelope\_links $_links                  = null;

}