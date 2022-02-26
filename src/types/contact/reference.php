<?php

namespace elite42\trackpms\types\contact;


class reference
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $salesLinkId = null;

	public ?int   $channelId   = null;

	public string $reference   = '';

}