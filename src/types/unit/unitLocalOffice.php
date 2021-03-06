<?php

namespace elite42\trackpms\types\unit;


class unitLocalOffice
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id              = null;

	public string                                    $name            = '';

	public string                                    $directions      = '';

	public string                                    $email           = '';

	public string                                    $phone           = '';

	public string                                    $streetAddress   = '';

	public string                                    $extendedAddress = '';

	public string                                    $locality        = '';

	public string                                    $region          = '';

	public string                                    $postalCode      = '';

	public string                                    $country         = '';

	public ?float                                    $latitude        = 0;

	public ?float                                    $longitude       = 0;

	public ?\DateTimeImmutable                       $createdAt       = null;

	public string                                    $createdBy       = '';

	public ?\DateTimeImmutable                       $updatedAt       = null;

	public string                                    $updatedBy       = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links          = null;

}