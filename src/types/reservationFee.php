<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getreservationfee
 */
class reservationFee
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                                 $id           = null;

	public ?int                                                 $chargeId     = null;

	public ?\elite42\trackpms\types\reservationFee\chargeInline $chargeInline = null;

	public float                                                $quantity     = 0;

	public bool                                                 $chargeOwner  = false;

	public float                                                $unitValue    = 0;

	public float                                                $value        = 0;

	public string                                               $displayAs    = '';

	public ?\DateTimeImmutable                                  $createdAt    = null;

	public string                                               $createdBy    = '';

	public ?\DateTimeImmutable                                  $updatedAt    = null;

	public string                                               $updatedBy    = '';

	public ?\elite42\trackpms\types\_envelope\_links            $_links       = null;

}