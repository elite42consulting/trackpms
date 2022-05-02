<?php

namespace elite42\trackpms\types;


class unitBlock
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                                                 $id                = null;

	public ?int                                                 $unitId            = null;

	public ?int                                                 $referenceId       = null;

	public ?int                                                 $blockReasonId     = null;

	public \elite42\trackpms\types\unitBlock\blockReason|null   $blockReasonInline = null;

	public ?int                                                 $cleanTypeId       = null;

	public string                                               $blockNotes        = '';

	public bool                                                 $chargeOwner       = false;

	public ?\DateTimeImmutable                                  $startDate         = null;

	public ?\DateTimeImmutable                                  $endDate           = null;

	public ?\DateTimeImmutable                                  $createdAt         = null;

	public string                                               $createdBy         = '';

	public ?\DateTimeImmutable                                  $updatedAt         = null;

	public string                                               $updatedBy         = '';

	public ?\elite42\trackpms\types\unitBlock\unitBlockEmbedded $_embedded         = null;

	public ?\elite42\trackpms\types\_envelope\_links            $_links            = null;

}