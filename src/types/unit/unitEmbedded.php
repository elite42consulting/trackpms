<?php

namespace elite42\trackpms\types\unit;


class unitEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

//	public ?\elite42\trackpms\types\node   $node              = null;

	public ?\elite42\trackpms\types\taxDistrict        $taxDistrict        = null;

	public ?\elite42\trackpms\types\unitType           $type               = null;

	public ?\elite42\trackpms\types\lodgingType        $lodgingType        = null;

	public ?\elite42\trackpms\types\cancellationPolicy $cancellationPolicy = null;

	public ?\elite42\trackpms\types\cleanStatus        $cleanStatus        = null;

	public ?\elite42\trackpms\types\system             $system             = null;

}