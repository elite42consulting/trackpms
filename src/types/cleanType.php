<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/getmaintworkorder
 */
class cleanType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public ?int    $id                       = null;
	public string  $type                     = '';
	public string  $code                     = '';
	public string  $name                     = '';
	public bool    $isActive                 = false;
	public bool    $chargeOwner              = false;
	public ?int    $chargeOwnerItemId        = null;
	public ?float  $chargeOwnerDefaultAmount = null;
	public bool    $generateLinenTicket      = false;
	public ?string $timeEstimate             = '';
	public ?int    $expenseAccountId         = null;

	//public  $expenseAccount = null;
	//public  $item = null;

	public ?int $taskListId = null;
	
	//public  $taskList = null;

	public ?\DateTimeImmutable $createdAt = null;

	public string $createdBy = '';

	public ?\DateTimeImmutable $updatedAt = null;

	public string $updatedBy = '';

	public ?\elite42\trackpms\types\housekeepingWorkOrder\housekeepingWorkOrderEmbedded $_embedded = null;

	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}
