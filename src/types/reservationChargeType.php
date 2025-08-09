<?php

namespace elite42\trackpms\types;

class reservationChargeType
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int                  $id;
	public ?string              $name              = null;
	public ?string              $display_name      = null;
	public ?float               $amount            = null;
	public ?string               $post_date         = '';
	public ?string               $rate_type         = '';
	public ?string               $frequency         = '';
	public ?\DateTimeImmutable  $startDate        = null;
	public ?\DateTimeImmutable  $endDate          = null;
	public ?int                 $date_group_id     = null;
	public ?string               $date_type         = 'none';
	public ?bool                 $split_with_owner  = false;
	public ?bool                 $edit_fee_amount   = false;
	public ?bool                 $allow_fee_removal = false;
	public ?bool                 $has_unit_pricing  = false;
	public ?string               $type              = 'required';
	public ?int                 $default_quantity  = null;
	public ?int                 $max_quantity      = null;
	public ?float               $minimum_amount    = null;
	public ?float               $maximum_amount    = null;
	public ?float               $mgmt_commission   = null;
	public ?int                 $item_id           = null;
	public ?bool                 $apply_unit_taxes  = false;
	public ?bool                 $include_in_deposit = false;
	public ?string               $created_by        = '';
	public ?string               $updated_by        = '';
	public ?\DateTimeImmutable $createdAt   = null;
	public ?\DateTimeImmutable $updatedAt   = null;
	public ?\DateTimeImmutable $deletedAt   = null;
	public ?int                 $max_nights        = null;
	public ?bool                 $charge_owner      = false;
	public ?bool                 $irm_enabled       = false;
	public ?bool                 $is_stacked        = false;
	public ?string               $display_as        = '';
	public ?string              $ha_product_code   = null;
	public ?string              $airbnb_product_code = null;
	public ?bool                 $is_active         = true;
	public ?int                  $min_stay_length   = 1;
	public ?int                 $max_stay_length   = null;
	public ?string              $fee_type          = null;
	public ?string              $tax_policy_type   = null;
	public ?bool                 $exclude_from_insurance = false;
	public ?bool                 $include_all_res_types  = false;
	public ?bool                 $require_funding        = false;
	public ?string               $template          = '';
	public ?bool                 $tripadvisor_enabled = false;
	public ?bool                $is_defer_exempted = null;
	public ?string              $hvmi_product_code = null;
	public ?bool                 $channel_stacked_fees = false;
	public ?string              $bookingdotcom_product_code = null;
	public ?string              $api_reference    = null;


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
		elseif($name == "start_date" && $value!==null) {
			$this->startDate = new \DateTimeImmutable($value);
		}
		elseif($name == "end_date" && $value!==null) {
			$this->endDate = new \DateTimeImmutable($value);
		}
	}

}
