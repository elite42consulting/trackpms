<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getmaintworkorder
 */
class maintenanceWorkOrder
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int                $id              = null;

	public string              $referenceNumber = '';

	public ?int                $priority        = null;

	public ?int                $completedById   = null;

	public ?int                $processedById   = null;

	public ?int                $unitId          = null;

	public ?\DateTimeImmutable $dateReceived    = null;

	public ?\DateTimeImmutable $dateScheduled   = null;

	public ?\DateTimeImmutable $dateCompleted   = null;

	public ?\DateTimeImmutable $dateProcessed   = null;

	public string              $description     = '';

	public string              $summary         = '';

	public string              $workPerformed   = '';

	public string              $status          = '';

	public string              $source          = '';

	public bool                $blockCheckin    = false;

	public string              $sourceName      = '';

	public string              $sourcePhone     = '';

	public string              $estimatedCost   = '';

	public string              $estimatedTime   = '';

	public string              $actualTime      = '';

	/** @var \elite42\trackpms\types\maintenanceWorkOrder\problem[] */
	public array $problems  = [];

	public array $assignees = [];

	public ?int  $userId    = null;

	public ?int  $vendorId  = null;

	public ?int  $ownerId   = null;

	//TODO: add type and uncomment
	//public string $owner = null;

	public ?int                                                                       $reservationId = null;

	public ?\DateTimeImmutable                                                        $createdAt     = null;

	public string                                                                     $createdBy     = '';

	public ?\DateTimeImmutable                                                        $updatedAt     = null;

	public string                                                                     $updatedBy     = '';

	public ?\elite42\trackpms\types\maintenanceWorkOrder\maintenanceWorkOrderEmbedded $_embedded     = null;

	public ?\elite42\trackpms\types\_envelope\_links                                  $_links        = null;

}