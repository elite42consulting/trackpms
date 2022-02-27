<?php

namespace elite42\trackpms\types\calendar;


class calendarGroup
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id        = null;

	public string                                    $name      = '';

	public ?\DateTimeImmutable                       $createdAt = null;

	public string                                    $createdBy = '';

	public ?\DateTimeImmutable                       $updatedAt = null;

	public string                                    $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links    = null;

}