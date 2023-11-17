<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/getmaintworkorder
 */
class housekeepingWorkOrder
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int $id = null;

	public ?\DateTimeImmutable $scheduledAt         = null;
	public ?\DateTimeImmutable $originalScheduledAt = null;
	public ?\DateTimeImmutable $completedAt         = null;
	public ?int                $completedById       = null;

	public ?\DateTimeImmutable $processedAt = null;

	public ?int   $processedById = null;
	public ?float $cost          = null;

	public string $comments = '';

	public ?int $unitId = null;

	public ?int $userId = null;

	/** @var \elite42\trackpms\types\user[] $assignees */
	public array  $assignees = [];
	public ?int   $vendorId  = null;
	public string $status    = '';

	public ?int    $cleanTypeId       = null;
	public bool    $isInspection      = false;
	public bool    $isTurn            = false;
	public bool    $isManual          = false;
	public bool    $chargeOwner       = false;
	public ?string $timeEstimate      = ''; //this may not be the correct type
	public ?string $actualTime        = ''; //this may not be the correct type
	public ?int    $unitBlockId       = null;
	public ?int    $reservationId     = null;
	public ?int    $nextReservationId = null;
	public ?int    $ownerId           = null;

	public ?\DateTimeImmutable $createdAt = null;

	public string $createdBy = '';

	public ?\DateTimeImmutable $updatedAt = null;

	public string $updatedBy = '';

	public ?\elite42\trackpms\types\housekeepingWorkOrder\housekeepingWorkOrderEmbedded $_embedded = null;

	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}
