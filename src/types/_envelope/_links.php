<?php

namespace elite42\trackpms\types\_envelope;


use elite42\trackpms\types\_envelope\link\link;
use JetBrains\PhpStorm\Pure;


class _links
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?link $self     = null;

	public ?link $first    = null;

	public ?link $last     = null;

	public ?link $next     = null;

	public ?link $prev     = null;

	public ?link $images   = null;

	public ?link $policies = null;

	public ?link $rooms    = null;

	public ?link $cancel   = null;

	public ?link $logs     = null;

	public ?link $notes    = null;

	public ?link $fees     = null;

	public ?link $tags     = null;

	public ?link $rates    = null;

	public ?link $discount = null;

	public ?link $checkin = null;

}