<?php

namespace elite42\trackpms\types\ownerUnit;


class ownerUnitEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\unit     $unit     = null;

	public ?\elite42\trackpms\types\owner    $owner    = null;

	public ?\elite42\trackpms\types\contract $contract = null;

}