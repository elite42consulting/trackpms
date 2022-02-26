<?php

namespace elite42\trackpms\types\customField;


class additionalProperties
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $maxLength     = null;

	public ?int   $minLength     = null;

	public ?int   $maxValue      = null;

	public ?int   $minValue      = null;

	public string $displayAs     = '';

	public bool   $allowRichText = false;

}