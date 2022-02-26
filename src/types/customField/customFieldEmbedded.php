<?php

namespace elite42\trackpms\types\customField;


class customFieldEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	/** @var \elite42\trackpms\types\customField\value[] */
	public array $values = [];

}