<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getitemcateogires
 */
class account
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                 $id                       = 0;
	public string              $name                     = '';
	public string              $code                     = '';
	public string              $description              = '';
	public string              $category                 = '';
	public string              $accountType              = '';
	public ?int                $parentId                 = null;
	public bool                $isActive                 = false;
	public ?int                $externalId               = null;
	public string              $externalName             = '';
	public string              $bankName                 = '';
	public string              $achEnabled               = '';
	public bool                $allowOwnerPayments       = false;
	public ?int                $achOrginId               = null;
	public ?int                $routingNumber            = null;
	public ?int                $accountNumber            = null;
	public string              $currency                 = '';
	public ?float              $currentBalance           = null;
	public ?float              $recursiveBalance         = null;
	public ?int                $immediateDestination     = null;
	public string              $immediateDestinationName = '';
	public string              $immediateOriginName      = '';
	public string              $companyName              = '';
	public ?int                $companyIdentification    = null;
	public ?int                $stakeholderId            = null;
	public bool                $enableRefunds            = false;
	public ?int                $defaultRefundAccount     = null;
	public ?\DateTimeImmutable $createdAt                = null;
	public string              $createdBy                = '';
	public ?\DateTimeImmutable $updatedAt                = null;
	public string              $updatedBy                = '';


	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}