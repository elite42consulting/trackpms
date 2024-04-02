<?php

namespace elite42\trackpms\types;


class contact
	extends
	\andrewsauder\jsonDeserialize\jsonDeserialize {

	public int    $id              = 0;

	public string $firstName       = '';

	public string $lastName        = '';

	public string $name            = '';

	public string $primaryEmail    = '';

	public string $secondaryEmail  = '';

	public string $homePhone       = '';

	public string $cellPhone       = '';

	public string $workPhone       = '';

	public string $otherPhone      = '';

	public string $fax             = '';

	public string $streetAddress   = '';

	public string $extendedAddress = '';

	public string $locality        = '';

	public string $region          = '';

	public string $postalCode      = '';

	public string $country         = '';

	public string $notes           = '';

	public string $anniversary     = '';

	public string $birthdate       = '';

	public bool   $noIdentity      = false;

	public bool   $isVip           = false;

	public bool   $isBlacklist     = false;

	public bool   $isDNR           = false;

	public bool   $isOwnerContact  = false;

	/** @var \elite42\trackpms\types\contact\tag[] $tags */
	public array $tags = [];

	/** @var \elite42\trackpms\types\contact\reference[] $references */
	public array $references = [];

//	public array                                     $custom     = [];

	public ?\DateTimeImmutable                       $createdAt = null;

	public string                                    $createdBy = '';

	public ?\DateTimeImmutable                       $updatedAt = null;

	public string                                    $updatedBy = '';

	public ?\elite42\trackpms\types\_envelope\_links $_links    = null;


	public function phonesToString() {
		$phoneStringParts = [];
		if( !empty( $this->cellPhone ) ) {
			$phoneStringParts[] = 'Cell: ' . $this->cellPhone;
		}
		if( !empty( $this->homePhone ) ) {
			$phoneStringParts[] = 'Home: ' . $this->homePhone;
		}
		if( !empty( $this->workPhone ) ) {
			$phoneStringParts[] = 'Work: ' . $this->homePhone;
		}
		if( !empty( $this->otherPhone ) ) {
			$phoneStringParts[] = 'Other: ' . $this->homePhone;
		}

		return implode( ', ', $phoneStringParts );
	}


	public function addressToString() {
		$addressParts = [];
		if( !empty( $this->streetAddress ) ) {
			$addressParts[] = $this->streetAddress;
		}
		if( !empty( $this->extendedAddress ) ) {
			$addressParts[] = $this->extendedAddress;
		}
		if( !empty( $this->locality ) ) {
			$addressParts[] = $this->locality;
		}
		if( !empty( $this->region ) || !empty( $this->postalCode ) ) {
			$stateZipParts = [];

			if( !empty( $this->region ) ) {
				$stateZipParts[] = $this->region;
			}
			if( !empty( $this->postalCode ) ) {
				$stateZipParts[] = $this->postalCode;
			}
			$addressParts[] = implode( ' ', $stateZipParts );
		}

		return implode( ', ', $addressParts );
	}


	public function emailsToString() {
		$emails = [];
		if( !empty( $this->primaryEmail ) ) {
			$emails[] = $this->primaryEmail;
		}
		if( !empty( $this->secondaryEmail ) ) {
			$emails[] = $this->secondaryEmail;
		}

		return implode( ', ', $emails );
	}

}
