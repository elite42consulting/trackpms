<?php

namespace elite42\trackpms\types\unit;


class unitBedType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id              = null;

	public string $name            = '';

	public string $count           = '';

	public string $tripadvisorType = '';

	public string $homeawayType    = '';

	public string $airbnbType      = '';

}