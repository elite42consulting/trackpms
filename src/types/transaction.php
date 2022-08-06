<?php

namespace elite42\trackpms\types;


/**
 * @see https://developer.trackhs.com/reference/getowneridtransactionscollection-1
 * @see https://developer.trackhs.com/reference/getowneridtransactionscollection
 */
class transaction
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                 $id            = 0;
	public string              $type          = '';
	public bool                $isPending     = false;
	public bool                $isDeferred    = false;
	public ?\DateTimeImmutable              $txnDate       = null;
	public string              $reference     = '';
	public ?int                $externalId    = null;
	public string              $currency      = '';
	public bool                $isVoided      = false;
	public ?int                $parentId      = null;
	public ?int                $contactId     = null;
	public ?int                $companyId     = null;
	public ?int                $workOrderId   = null;
	public ?int                $hkWorkOrderId = null;
	public string              $dueDate       = '';
	public bool                $taxExempt     = false;
	public ?float              $subTotal      = null;
	public ?float              $taxAmount     = null;
	public ?float              $amount        = null;
	public string              $voidReason    = '';
	public ?int                $transactionId = null;
	public string              $memo          = '';
	public bool                $isAuthOnly    = false;
	public ?int                $depositId     = null;
	public ?int                $paymentTypeId = null;
	public string              $billType      = '';
	public ?int                $vendorId      = null;
	public string              $vendorName    = '';
	public string              $invoiceNumber = '';
	public string              $APAccountId   = '';
	public string              $terms         = '';
	public ?float              $balance       = null;
	public ?\DateTimeImmutable $createdAt     = null;
	public string              $createdBy     = '';
	public ?\DateTimeImmutable $updatedAt     = null;
	public string              $updatedBy     = '';

	public ?\elite42\trackpms\types\transaction\ownerTransaction       $ownerTransaction       = null;
	public ?\elite42\trackpms\types\transaction\cityAccountTransaction $cityAccountTransaction = null;
	public ?\elite42\trackpms\types\transaction\folioTransaction       $folioTransaction       = null;

	/** @var \elite42\trackpms\types\transaction\line[] */
	public array $lines = [];

	public ?\elite42\trackpms\types\transaction\transactionEmbedded $_embedded = null;


	public ?\elite42\trackpms\types\_envelope\_links $_links = null;

}