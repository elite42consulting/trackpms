<?php

namespace elite42\trackpms\types\unit;


/**
 * @see https://developer.trackhs.com/reference/getcustomfield
 */
class unitCustomFields
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public string $pms_units_source_unit_id                                     = '';

	public string $pms_units_wifi_code                                          = '';

	public string $pms_units_for_sale_status                                    = '';

	public string $pms_units_real_estate_agent                                  = '';

	public string $pms_units_real_estate_agent_phone                            = '';

	public string $pms_units_dog_permission_status                              = '';

	public bool   $pms_units_does_owner_bring_pet                               = false;

	public bool   $pms_units_carc_membership                                    = false;

	public array  $pms_units_community_enforcements                             = [];

	public bool   $pms_units_eci_lco_allowed                                    = false;

	public int    $pms_units_occupancy_alpha_list                               = 10;

	public string $pms_units_floor_plan                                         = '';

	public array  $pms_units_vacation_rewards                                   = [];

	public string $pms_units_vacation_rewards_winter                            = '';

	public string $pms_units_vacation_rewards_ex_winter                         = '';

	public string $pms_units_vacation_rewards_springoos                         = '';

	public string $pms_units_vacation_rewards_spring                            = '';

	public string $pms_units_vacation_rewards_summer                            = '';

	public string $pms_units_vacation_rewards_fall                              = '';

	public string $pms_units_vacation_rewards_falloos                           = '';

	public array  $pms_units_special_night_restrictions                         = [];

	public string $pms_units_alarm_info                                         = '';

	public string $pms_units_driveway_rating                                    = '';

	public string $pms_units_winter_rental_driveway_rating_explanation          = '';

	public ?int   $pms_units_max_vehicles_permitted                             = null;

	public string $pms_units_renter_in_program                                  = '';

	public bool   $pms_units_owner_cleaned_property                             = false;

	public ?int   $pms_units_no_breaker_boxes                                   = null;

	public string $pms_units_breaker_box_locations                              = '';

	public string $pms_units_water_type                                         = '';

	public string $pms_units_well_location_information                          = '';

	public string $pms_units_water_valve_location                               = '';

	public string $pms_units_water_system_information                           = '';

	public string $pms_units_uv_light                                           = '';

	public string $pms_units_thermostat_location_information                    = '';

	public string $pms_units_fuel_vendor_account_information                    = '';

	public string $pms_units_fuel_tank_location                                 = '';

	public string $pms_units_furnace_filter_location_information                = '';

	public string $pms_units_fireplace_information                              = '';

	public string $pms_units_preferred_vendors                                  = '';

	public string $pms_units_vendors_not_permitted_at_home                      = '';

	public string $pms_units_dock_vendor_information                            = '';

	public string $pms_units_lawn_vendor_information                            = '';

	public string $pms_units_wood_vendor_information                            = '';

	public string $pms_units_plow_vendor_information                            = '';

	public string $pms_units_trash_vendor_information                           = '';

	public string $pms_units_pest_control_vendor_information                    = '';

	public string $pms_units_hvac_vendor_information                            = '';

	public string $pms_units_home_phone_provider_information                    = '';

	public string $pms_units_cable_provider_information                         = '';

	public string $pms_units_internet_provider_information                      = '';

	public string $pms_units_internet_router_location                           = '';

	public string $pms_units_internet_speeds                                    = '';

	public string $pms_units_tp_link_deco                                       = '';

	public bool   $pms_units_rv_comcast_package                                 = false;

	public int    $pms_units_hot_tub_zone                                       = 0;

	public string $pms_units_hot_tub_information                                = '';

	public string $pms_units_pool_information                                   = '';

	public string $pms_units_appliance_information                              = '';

	public string $pms_units_property_notes_fyis_maintenance                    = '';

	public string $pms_units_laundry_unit_code                                  = '';

	public string $pms_units_coa_details_for_guest_emails                       = '';

	public bool   $pms_units_rci_home                                           = false;

	public string $pms_units_entry_lock_type                                    = '';

	public string $pms_units_code_details_for_emails                            = '';

	public string $pms_units_eci_lco_details                                    = '';

	public string $pms_units_check_in_instructions                              = '';

	public string $pms_units_check_out_instructions                             = '';

	public string $pms_units_private_pool                                       = '';

	public int    $pms_units_hot_tubs_to_service_hot_tub_scheduler              = 0;

	public int    $pms_units_pools_to_service_hot_tub_scheduler                 = 0;

	public string $pms_units_neighborhood                                       = '';

	public string $pms_units_dock_directions_guest_use                          = '';

	public string $pms_units_lake_access_directions_guest_use                   = '';

	public string $pms_units_firewood_for_guest_use                             = '';

	public string $pms_units_trash_access_directions_guest_use                  = '';

	public string $pms_units_extra_community_perks                              = '';

	public string $pms_units_ge_compensation                                    = '';

	public string $pms_units_docs_community_specific_details                    = '';

	public string $pms_units_docs_house_specific_details                        = '';

	public string $pms_units_docs_t_c_specific_details                          = '';

	public string $pms_units_fridge_sheets_be_a_good_neighbor                   = '';

	public string $pms_units_important_property_notifications_website_check_out = '';

	public string $pms_units_ssid_wifi_name                                     = '';

	public string $pms_units_ota_links_vrbo                                     = '';

	public string $pms_units_ota_links_marriott                                 = '';

	public string $pms_units_ota_links_airbnb                                   = '';

	public string $pms_units_realtor_box_code                                   = '';

	public string $pms_units_occ_restriction_fire_code                          = '';

	public string $pms_units_it_dept_notes                                      = '';

	public string $pms_units_hot_tub_outage_reimbursement                       = '';

	public string $pms_units_dock_id                                            = '';

	public string $pms_units_maintenance_links                                  = '';

	public string $pms_units_minimum_rental_age                                 = '';

	public $pms_units_owners_codes= null;
	public $pms_units_owners_codes_other= null;
	public $pms_units_internal_use_only_troubleshooting_guides= null;
	public $pms_units_policy_opt_outs= null;
	public $pms_units_channel_opt_outs= null;
	public $pms_units_coi_expiration_date= null;
	public $pms_units_hvmi_rejection_reason_s= null;
	public $pms_units_direct_review_link= null;
	public $pms_units_direct_memories_link= null;
	public $pms_units_area_of_lake= null;
	public $pms_units_promotions= null;
	public $pms_units_outdoor_camera_s_installed= null;
	public $pms_units_outdoor_camera_locations= null;
	public $pms_units_indoor_cameras_installed= null;
	public $pms_units_indoor_camera_locations= null;
	public $pms_units_breaker_box_locations_1= null;
	public $pms_units_annual_free_cleans= null;
	public $pms_units_annual_free_linens= null;
	public $pms_units_annual_free_clean_linen_notes= null;
	public $pms_units_public_sewage_or_septic_system= null;
	public $pms_units_grill_has_propane_direct_line= null;
	public $pms_units_home_fuel_on_auto_refill= null;
	public $pms_units_a_c_type= null;
	public $pms_units_cable_channel_guide= null;
	public $pms_units_hot_tub_vendor= null;
	public $pms_units_hot_tub_filter= null;
	public $pms_units_pool_filter= null;
	public $pms_units_ge_waiver_amenity_list= null;
	public $pms_units_google_map_link= null;
	public $pms_units_ge_damage= null;
	public $pms_units_ge_damage_response_date= null;
	public $pms_units_docs_t_c_link_generic= null;
	public $pms_units_cxl_policy= null;
	public $pms_units_custom_t_c_stilwater= null;
	public $pms_units_maintenance_warnings_portal= null;
	public $pms_units_pm_receives_check_out_notice= null;
	public $pms_units_lost_found_form= null;

}
