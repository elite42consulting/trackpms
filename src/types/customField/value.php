<?php

namespace elite42\trackpms\types\customField;


class value
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int   $id     = null;

	public string $handle = '';

	public string $value  = '';

	public string $name  = '';

	public ?int   $order  = null;

	public ?\DateTimeImmutable                       $removedAt = null;

	public ?\DateTimeImmutable                       $createdAt = null;

	public string                                    $createdBy = '';

	public ?\DateTimeImmutable                       $updatedAt = null;

	public string                                    $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links    = null;

}