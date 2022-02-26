<?php

namespace elite42\trackpms\types;


class paymentMethod
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id             = 0;

	public string                                    $type           = '';

	public bool                                      $isDefault      = false;

	public string                                    $cardNumber     = '';

	public string                                    $cardExpiration = '';

	public string                                    $cardType       = '';

	public string                                    $routingNumber  = '';

	public string                                    $accountNumber  = '';

	public string                                    $accountType    = '';

	public string                                    $name           = '';

	public bool                                      $isRedacted     = false;

	public bool                                      $isVirtual      = false;

	public ?\DateTimeImmutable                       $effectiveDate  = null;

	public ?\DateTimeImmutable                       $createdAt      = null;

	public string                                    $createdBy      = '';

	public ?\DateTimeImmutable                       $updatedAt      = null;

	public string                                    $updatedBy      = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links         = null;

}