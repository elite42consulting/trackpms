<?php

namespace elite42\trackpms\types;


class cancellationReason
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id               = 0;

	public string                                    $name             = '';

	public string                                    $handle           = '';

	public bool                                      $isActive         = false;

	public bool                                      $cancelledByGuest = false;

	public ?int                                      $airbnbType       = null;

	public ?\DateTimeImmutable                       $createdAt        = null;

	public string                                    $createdBy        = '';

	public ?\DateTimeImmutable                       $updatedAt        = null;

	public string                                    $updatedBy        = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links           = null;

}