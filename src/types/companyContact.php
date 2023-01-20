<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/getcompanyattachments
 */
class companyContact
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public bool                                                    $isPrimaryContact = false;
	public float                                                   $ownerSplit       = 0;
	public ?int                                                    $contactId        = null;
	public ?int                                                    $companyId        = null;
	public string                                                  $ownerType        = '';
	public ?\elite42\trackpms\types\company\companyContactEmbedded $_embedded        = null;
	public ?\elite42\trackpms\types\_envelope\_links               $_links           = null;

}
