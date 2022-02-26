<?php

namespace elite42\trackpms\types\reservation;


class reservationEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\contact            $contact            = null;

	public ?\elite42\trackpms\types\folio              $folio              = null;

	public ?\elite42\trackpms\types\unit               $unit               = null;

	public ?\elite42\trackpms\types\cancellationReason $cancellationReason = null;

	public ?\elite42\trackpms\types\rateType           $rateType           = null;

	public ?\elite42\trackpms\types\user               $user               = null;

	public ?\elite42\trackpms\types\user               $canceledBy         = null;

	public ?\elite42\trackpms\types\paymentMethod      $paymentMethod      = null;

	public ?\elite42\trackpms\types\campaign           $campaign           = null;

}