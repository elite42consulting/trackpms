<?php

namespace elite42\trackpms\types\node;


class nodeEmbedded
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?\elite42\trackpms\types\_envelope\_linksWrapper $parent             = null;

	public ?\elite42\trackpms\types\_envelope\_linksWrapper $type               = null;

	public ?\elite42\trackpms\types\_envelope\_linksWrapper $taxDistrict        = null;

	public ?\elite42\trackpms\types\_envelope\_linksWrapper $cancellationPolicy = null;

}