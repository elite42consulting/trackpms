<?php

namespace elite42\trackpms\types\transaction;

class transactionEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\transaction          $parent      = null;
	public ?\elite42\trackpms\types\maintenanceWorkOrder $workOrder   = null;
	public ?\elite42\trackpms\types\unit                 $unit        = null;
	public ?\elite42\trackpms\types\reservation          $reservation = null;

}