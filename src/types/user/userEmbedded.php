<?php

namespace elite42\trackpms\types\user;

class userEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\role   $role   = null;
	public ?\elite42\trackpms\types\vendor $vendor = null;

}
