<?php

namespace elite42\trackpms\types\contract;


class commissionValue
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int  $typeId       = null;

	public bool  $isActive     = false;

	public bool  $hasOverrides = false;

	public float $commission   = 0;

	//TODO: add array type
	public array $overrides = [];

}