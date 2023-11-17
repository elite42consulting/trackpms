<?php

namespace elite42\trackpms\types\housekeepingWorkOrder;

class housekeepingWorkOrderEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\cleanType $cleanType = null;

	public ?\elite42\trackpms\types\unit $unit = null;

	public ?\elite42\trackpms\types\user $user = null;

	public ?\elite42\trackpms\types\vendor $vendor = null;

	public ?\elite42\trackpms\types\reservation $reservation = null;

	public ?\elite42\trackpms\types\reservation $nextReservation = null;

}
