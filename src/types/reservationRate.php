<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getratesreservation
 */
class reservationRate
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\DateTimeImmutable $date   = null;

	public float               $rate   = 0;

	public int                 $nights = 0;

}