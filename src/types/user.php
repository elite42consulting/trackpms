<?php

namespace elite42\trackpms\types;


class user
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id         = 0;

	public bool                                      $isActive   = false;

	public string                                    $name       = '';

	public string                                    $phone      = '';

	public string                                    $email      = '';

	public string                                    $username   = '';

	public ?int                                      $roleId     = null;

	public ?int                                      $teamId     = null;

	public ?int                                      $vendorId   = null;

	/** @var string[] */
	public array                                     $assignable = [];

	public ?\DateTimeImmutable                       $createdAt  = null;

	public string                                    $createdBy  = '';

	public ?\DateTimeImmutable                       $updatedAt  = null;

	public string                                    $updatedBy  = '';

	public ?\elite42\trackpms\types\user\userEmbedded $_embedded             = null;

	public ?\elite42\trackpms\types\_envelope\_links $_links     = null;

}
