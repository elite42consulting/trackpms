<?php

namespace elite42\trackpms\types;

class reservationChargeTypePerUnit
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                  $id;
	public int                  $charge_id;
	public ?int                 $unit_id                 = null;
	public ?int                 $unit_type_id            = null;
	public ?int                 $reservation_type_id     = null;
	public ?int                  $constraint_res_type_id = null;
	public ?int                 $max_qty                 = null;
	public ?int                 $default_qty             = null;
	public ?float               $value                   = null;
	public ?float               $minimum_amount          = null;
	public ?float               $maximum_amount          = null;
	public ?bool                $split_with_owner        = null;
	public ?float               $mgmt_commission         = null;
	public ?string               $created_by              = '';
	public ?string               $updated_by              = '';
	public ?int                 $max_nights              = null;
	public ?bool                $charge_owner            = null;
	public ?string              $display_as              = null;
	public ?int                 $charge_group_id         = null;
	public ?int                  $constraint_charge_group_id = null;

	public ?\DateTimeImmutable $createdAt   = null;
	public ?\DateTimeImmutable $updatedAt   = null;
	public ?\DateTimeImmutable $deletedAt   = null;


	function __set($name, $value) {
		if($name == "created_at" && $value!==null) {
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
