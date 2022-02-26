<?php

namespace elite42\trackpms\types\reservation\quoteBreakdown;


class fee
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public string $display = '';

	public string $label   = '';

	public float  $value   = 0;

}