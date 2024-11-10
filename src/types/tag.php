<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/gettag
 */
class tag
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $id = null;

	public string $name = '';
	public string $color = '';
	public string $description = '';
	public string $relatedTo = '';

	public ?\DateTimeImmutable $createdAt = null;

	public string $createdBy = '';

	public ?\DateTimeImmutable $updatedAt = null;

	public string $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}
