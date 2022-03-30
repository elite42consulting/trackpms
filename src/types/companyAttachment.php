<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getcompanyattachments
 */
class companyAttachment
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                      $id                         = null;

	public string                                    $name                       = '';

	public bool                                      $isPublic                   = false;

	public string                                    $fileType                 = '';

	public string                                    $fileUrl                       = '';

	public ?\DateTimeImmutable                       $createdAt                  = null;

	public string                                    $createdBy                  = '';

	public ?\DateTimeImmutable                       $updatedAt                  = null;

	public string                                    $updatedBy                  = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links                     = null;

}
