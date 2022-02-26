<?php

namespace elite42\trackpms\types;


class folio
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                       $id                = 0;

	public string                                    $type              = '';

	public string                                    $status            = '';

	public ?int                                      $contactId         = null;

	public ?int                                      $companyId         = null;

	public mixed                                     $company           = null;

	public bool                                      $taxExempt         = false;

	public ?\DateTimeImmutable                       $startDate         = null;

	public ?\DateTimeImmutable                       $endDate           = null;

	public ?\DateTimeImmutable                       $closedDate        = null;

	public float                                     $realizedBalance   = 0;

	public float                                     $currentBalance    = 0;

	public ?\DateTimeImmutable                       $createdAt         = null;

	public string                                    $createdBy         = '';

	public ?\DateTimeImmutable                       $updatedAt         = null;

	public string                                    $updatedBy         = '';

	public string                                    $name              = '';

	public ?int                                      $reservationId     = null;

	public ?int                                      $travelAgentId     = null;

	public mixed                                     $travelAgent       = null;

	public bool                                      $hasException      = false;
	public bool                                      $posAllow      = false;
	public float                                      $posLimit      = 0;

	public string                                    $exceptionMessage  = '';

	public ?\DateTimeImmutable                       $checkInDate       = null;

	public ?\DateTimeImmutable                       $checkOutDate      = null;

	public float                                     $ownerRevenue      = 0;

	public float                                     $ownerCommission   = 0;

	public float                                     $agentCommission   = 0;

	public ?int                                      $masterFolioId     = null;

	public mixed                                     $masterFolio       = null;

	public ?int                                      $masterFolioRuleId = null;

	public mixed                                     $masterFolioRule   = null;

	public ?\elite42\trackpms\types\_envelope\_links $_links            = null;

}