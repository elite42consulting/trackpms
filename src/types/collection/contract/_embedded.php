<?php

namespace elite42\trackpms\types\collection\contract;


class  _embedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	/** @var \elite42\trackpms\types\contract[] */
	public array $contracts = [];

}