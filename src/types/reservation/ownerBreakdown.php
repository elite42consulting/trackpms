<?php

namespace elite42\trackpms\types\reservation;


class ownerBreakdown
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public float $grossRent         = 0;

	public float $feeRevenue        = 0;

	public float $grossRevenue      = 0;

	public float $managerCommission = 0;

	public float $agentCommission   = 0;

	public float $netRevenue        = 0;

}