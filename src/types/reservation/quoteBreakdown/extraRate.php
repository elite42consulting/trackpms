<?php

namespace elite42\trackpms\types\reservation\quoteBreakdown;


class extraRate
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int  $id       = null;

	public float $charge   = 0;

	public int   $quantity = 0;

}