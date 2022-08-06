<?php

namespace elite42\trackpms\types\collection\transaction;


class  _embedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	/** @var \elite42\trackpms\types\transaction[] */
	public array $blocks = [];

}