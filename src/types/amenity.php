<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getamenity
 */
class amenity
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id              = 0;

	public string                                    $name            = '';

	public ?int                                      $groupId         = null;

	public ?\elite42\trackpms\types\amenity\group    $group           = null;

	public string                                    $homeawayType    = '';

	public string                                    $airbnbType      = '';

	public string                                    $tripadvisorType = '';

	public ?\DateTimeImmutable                       $createdAt       = null;

	public string                                    $createdBy       = '';

	public ?\DateTimeImmutable                       $updatedAt       = null;

	public string                                    $updatedBy       = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links          = null;

}