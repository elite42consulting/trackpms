<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getownerunitscollection
 */
class ownerUnit
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                                 $id                    = null;

	public ?int                                                 $ownerId               = null;

	public ?int                                                 $unitId                = null;

	public ?int                                                 $contractId            = null;

	public ?int                                                 $fractionalInventoryId = null;

	public string                                               $contractType          = '';

	public string                                               $taxMode               = '';

	public ?\DateTimeImmutable                                  $startDate             = null;

	public ?\DateTimeImmutable                                  $endDate               = null;

	public ?\DateTimeImmutable                                  $createdAt             = null;

	public string                                               $createdBy             = '';

	public ?\DateTimeImmutable                                  $updatedAt             = null;

	public string                                               $updatedBy             = '';

	public ?\elite42\trackpms\types\ownerUnit\ownerUnitEmbedded $_embedded             = null;

	public ?\elite42\trackpms\types\_envelope\_links            $_links                = null;

}