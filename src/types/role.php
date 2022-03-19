<?php

namespace elite42\trackpms\types;


class role
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id          = null;

	public string $name        = '';

	public bool   $isSystem    = false;

	public bool   $isSuperUser = false;

	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}