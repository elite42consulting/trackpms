<?php

namespace elite42\trackpms\types;


class lodgingType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id                 = null;

	public string                                    $name               = '';

	public string                                    $code               = '';

	public string                                    $homeawayType       = '';

	public string                                    $airbnbTypeCategory = '';

	public string                                    $airbnbTypeGroup    = '';

	public string                                    $tripadvisorType    = '';

	public bool                                      $isActive           = false;

	public ?\DateTimeImmutable                       $createdAt          = null;

	public string                                    $createdBy          = '';

	public ?\DateTimeImmutable                       $updatedAt          = null;

	public string                                    $updatedBy          = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links             = null;

}