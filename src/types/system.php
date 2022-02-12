<?php

namespace elite42\trackpms\types;


class system
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id        = null;

	public string                                    $name      = '';

	public string                                    $type      = '';

	public string                                    $handle    = '';

	public bool                                      $isActive  = false;

	public array                                     $params    = [];

	public ?\DateTimeImmutable                       $createdAt = null;

	public string                                    $createdBy = '';

	public ?\DateTimeImmutable                       $updatedAt = null;

	public string                                    $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links    = null;

}