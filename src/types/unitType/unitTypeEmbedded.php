<?php

namespace elite42\trackpms\types\unitType;


class unitTypeEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\lodgingType        $lodgingType        = null;
	public ?\elite42\trackpms\types\calendar\calendarGroup        $calendarGroup        = null;

}