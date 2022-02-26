<?php

namespace elite42\trackpms\types\reservation;


class typeInline
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id              = null;

	public string $name            = '';

	public string $code           = '';

}