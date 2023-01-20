<?php

namespace elite42\trackpms\types\company;

class companyContactEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\contact $contact = null;

	public ?\elite42\trackpms\types\company $company = null;

}