<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/getamenitygrouponunit
 */
class amenityGroup extends \andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id              = 0;

	public string                                    $name            = '';

	public ?\DateTimeImmutable                       $createdAt       = null;

	public string                                    $createdBy       = '';

	public ?\DateTimeImmutable                       $updatedAt       = null;

	public string                                    $updatedBy       = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links          = null;
}