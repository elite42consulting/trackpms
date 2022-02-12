<?php

namespace elite42\trackpms\types;


class role
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id             = null;

	public string                                    $name           = '';

	public string                                    $code           = '';

	public string                                    $handle         = '';

	public bool                                      $isReport       = false;

	public bool                                      $isReservations = false;

	public bool                                      $isHousekeeping = false;

	public bool                                      $isMaintenance  = false;

	public bool                                      $isOwners       = false;

	public bool                                      $isActive       = false;

	public ?\DateTimeImmutable                       $createdAt      = null;

	public string                                    $createdBy      = '';

	public ?\DateTimeImmutable                       $updatedAt      = null;

	public string                                    $updatedBy      = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links         = null;

}