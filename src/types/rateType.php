<?php

namespace elite42\trackpms\types;


class rateType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id            = 0;

	public string                                    $type          = '';

	public string                                    $code          = '';

	public string                                    $name          = '';

	public bool                                      $isAllChannels = false;

	public ?int                                      $channelId     = null;

	public bool                                      $isActive      = false;
	public bool                                      $isAutoSelect      = false;
	public bool                                      $occupancyPricingByType      = false;

	public ?\DateTimeImmutable                       $createdAt     = null;

	public string                                    $createdBy     = '';

	public ?\DateTimeImmutable                       $updatedAt     = null;

	public string                                    $updatedBy     = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links        = null;

}