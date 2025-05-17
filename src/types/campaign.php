<?php

namespace elite42\trackpms\types;


class campaign
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id                = 0;

	public bool                                      $isActive          = false;

	public string                                    $name              = '';

	public ?int                                      $brandId           = null;

	public                                           $brand             = null;

	public string                                    $description       = '';

	public string                                    $token             = '';

	public string                                    $email             = '';

	public string                                    $url               = '';

	public ?int                                      $primaryNumberId   = null;

	public                                     $primaryNumber     = '';

	public bool                                      $disableRecording  = false;

	public ?\DateTimeImmutable                       $startDate         = null;

	public ?\DateTimeImmutable                       $endDate           = null;

	public ?int                                      $defaultLeadTypeId = null;

	public                                     $defaultLeadType   = null;

	public ?\DateTimeImmutable                       $createdAt         = null;

	public string                                    $createdBy         = '';

	public ?\DateTimeImmutable                       $updatedAt         = null;

	public string                                    $updatedBy         = '';

	public string                                    $keywords          = '';

	//TODO: add array type
	public array                                     $tags              = [];

	public ?\elite42\trackpms\types\_envelope\_links $_links            = null;

}
