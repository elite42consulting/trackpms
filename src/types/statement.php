<?php

namespace elite42\trackpms\types;

/**
 * @see https://developer.trackhs.com/reference/get-pms-statement
 */
class statement
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                                        $id                  = 0;
	public int                                        $ownerId             = 0;
	public ?\DateTimeImmutable                        $statementDate       = null;
	public ?int                                       $year                = null;
	public ?int                                       $period              = null;
	public float                                      $minBalance          = 0;
	public float                                      $balanceForward      = 0;
	public float                                      $revenue             = 0;
	public float                                      $charges             = 0;
	public float                                      $net                 = 0;
	public float                                      $paidOut             = 0;
	public float                                      $paidIn              = 0;
	public float                                      $dueToOwner          = 0;
	public float                                      $dueByOwner          = 0;
	public float                                      $endingBalances      = 0;
	public bool                                       $isAnnual            = false;
	public bool                                       $isPublished         = false;
	public float                                      $trustAccountBalance = 0;
	public ?\DateTimeImmutable                        $createdAt           = null;
	public string                                     $createdBy           = '';
	public ?\DateTimeImmutable                        $updatedAt           = null;
	public string                                     $updatedBy           = '';
	public ?\elite42\trackpms\types\unit\unitEmbedded $_embedded           = null;
	public ?\elite42\trackpms\types\_envelope\_links  $_links              = null;

}