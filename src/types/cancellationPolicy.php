<?php

namespace elite42\trackpms\types;


class cancellationPolicy
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                $id               = null;

	public bool                $isDefault        = false;

	public bool                $isActive         = false;

	public string              $name             = '';

	public ?\DateTimeImmutable $createdAt        = null;

	public string              $createdBy        = '';

	public ?\DateTimeImmutable $updatedAt        = null;

	public string              $updatedBy        = '';

	public string              $code             = '';

	public string              $chargeAs         = '';

	public bool                $canExceedBalance = false;

	public string              $cancelTime       = '';

	public string              $cancelTimezone   = '';

	public string              $postDate         = '';

	public string              $tripadvisorType  = '';

	public string              $homeawayType     = '';

	public string              $airbnbType       = '';

}