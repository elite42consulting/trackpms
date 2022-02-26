<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getreservationnote
 */
class reservationNote
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id        = null;

	public string                                    $note      = '';

	public bool                                      $isPublic  = false;

	public ?\DateTimeImmutable                       $createdAt = null;

	public string                                    $createdBy = '';

	public ?\DateTimeImmutable                       $updatedAt = null;

	public string                                    $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links    = null;

}