<?php

namespace elite42\trackpms\types\reservation\quoteBreakdown;


class rate
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\DateTimeImmutable $date = null;

	public float $rate     = 0;

	public int   $nights   = 0;

	public bool  $isQuoted = false;

}