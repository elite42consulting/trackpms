<?php

namespace elite42\trackpms\types;

class journal
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                 $id;
	public int                 $trn_date_id;
	public ?int                $parent_id   = null;
	public string              $type        = '';
	public ?\DateTimeImmutable $transactionDate    = null;
	public ?string             $memo        = null;
	public ?string             $public_memo = null;
	public ?string             $reference   = null;
	public ?string             $external_id = null;
	public bool                $is_voided   = false;
	public bool                $is_pending  = false;
	public bool                $is_deferred = false;
	public bool                $sync_date   = false;
	public string              $currency    = '';
	public ?\DateTimeImmutable $createdAt   = null;
	public string              $createdBy   = '';
	public ?\DateTimeImmutable $updatedAt   = null;
	public string              $updatedBy   = '';
	public ?\DateTimeImmutable $deletedAt   = null;

	function __set($name, $value) {
		if($name == "txn_date" && $value!==null) {
			$this->transactionDate = new \DateTimeImmutable($value);
		}
		elseif($name == "created_at" && $value!==null) {
			$this->createdAt = new \DateTimeImmutable($value);
		}
		elseif($name == "updated_at" && $value!==null) {
			$this->updatedAt = new \DateTimeImmutable($value);
		}
		elseif($name == "deleted_at" && $value!==null) {
			$this->deletedAt = new \DateTimeImmutable($value);
		}
	}
}
