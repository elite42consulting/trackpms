<?php

namespace elite42\trackpms\types;


use elite42\trackpms\types\_envelope\_links;


class zone
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                $id        = null;

	public bool                $isActive  = false;

	public string              $name      = '';

	public string              $type      = '';

	public ?\DateTimeImmutable $createdAt = null;

	public string              $createdBy = '';

	public ?\DateTimeImmutable $updatedAt = null;

	public string              $updatedBy = '';

	public ?_links             $_links    = null;

}