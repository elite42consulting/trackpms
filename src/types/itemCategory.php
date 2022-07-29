<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getitemcateogires
 */
class itemCategory
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int    $id     = 0;
	public string $name   = '';
	public string $handle = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}