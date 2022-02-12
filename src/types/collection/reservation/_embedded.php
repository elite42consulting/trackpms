<?php

namespace elite42\trackpms\types\collection\reservation;


class  _embedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	/** @var \elite42\trackpms\types\reservation[] */
	public array $reservations = [];

}