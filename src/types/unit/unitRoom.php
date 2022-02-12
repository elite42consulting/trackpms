<?php

namespace elite42\trackpms\types\unit;


class unitRoom
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public string $name  = '';
	public string $type  = '';
	public string $description  = '';

	public ?int   $sleeps = null;
	public bool   $hasAttachedBathroom = false;

	/** @var \elite42\trackpms\types\unit\unitBedType[] */
	public array $beds = [];

	public ?int   $order = null;

	public string $tripadvisorType = '';

	public string $homeawayType    = '';

	public string $airbnbType      = '';

}