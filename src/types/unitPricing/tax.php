<?php

namespace elite42\trackpms\types\unitPricing;

class tax
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $id = null;

	public string $name = '';

	public string $type = '';

	public float $rate = 0;

	public bool $isExemptible = false;

	public ?\DateTimeImmutable $startDate = null;

	public ?\DateTimeImmutable $endDate = null;

	public ?\elite42\trackpms\types\unitPricing\taxRent $rent = null;

}
