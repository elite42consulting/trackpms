<?php

namespace elite42\trackpms\types\maintenanceWorkOrder;

class maintenanceWorkOrderEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\unit   $unit   = null;
	public ?\elite42\trackpms\types\vendor $vendor = null;
	public ?\elite42\trackpms\types\owner  $owner  = null;
	public ?\elite42\trackpms\types\user   $user   = null;

}