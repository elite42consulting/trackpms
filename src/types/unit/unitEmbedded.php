<?php

namespace elite42\trackpms\types\unit;


class unitEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\node                            $node                   = null;

	public ?\elite42\trackpms\types\taxDistrict                     $taxDistrict            = null;

	public ?\elite42\trackpms\types\unitType                        $type                   = null;

	public ?\elite42\trackpms\types\lodgingType                     $lodgingType            = null;

	public ?\elite42\trackpms\types\cancellationPolicy              $cancellationPolicy     = null;

	public ?\elite42\trackpms\types\cleanStatus                     $cleanStatus            = null;

	public ?\elite42\trackpms\types\system                          $system                 = null;

	public ?\elite42\trackpms\types\zone                            $housekeepingZone       = null;

	public ?\elite42\trackpms\types\zone                            $maintenanceZone        = null;

	public ?\elite42\trackpms\types\unit\unitTravelInsuranceProduct $travelInsuranceProduct = null;

	public ?\elite42\trackpms\types\unit\unitLocalOffice            $localOffice            = null;

	/** @var \elite42\trackpms\types\owner[] */
	public array $owners = [];

	/** @var \elite42\trackpms\types\contact[] */
	public array $contacts = [];

}