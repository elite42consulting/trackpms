<?php

namespace elite42\trackpms\types\collection\user;


class  _embedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	/** @var \elite42\trackpms\types\user[] */
	public array $users = [];

}