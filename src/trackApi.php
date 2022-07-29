<?php
namespace elite42\trackpms;


use andrewsauder\jsonDeserialize\exceptions\jsonDeserializeException;
use elite42\trackpms\types\account;
use elite42\trackpms\types\amenity;
use elite42\trackpms\types\amenityGroup;
use elite42\trackpms\types\collection\accountCollection;
use elite42\trackpms\types\collection\amenityCollection;
use elite42\trackpms\types\collection\amenityGroupCollection;
use elite42\trackpms\types\collection\companyAttachmentCollection;
use elite42\trackpms\types\collection\companyCollection;
use elite42\trackpms\types\collection\contractCollection;
use elite42\trackpms\types\collection\customFieldCollection;
use elite42\trackpms\types\collection\maintenanceWorkOrderCollection;
use elite42\trackpms\types\collection\ownerCollection;
use elite42\trackpms\types\collection\ownerUnitCollection;
use elite42\trackpms\types\collection\reservationAttachmentCollection;
use elite42\trackpms\types\collection\reservationCollection;
use elite42\trackpms\types\collection\reservationFeeCollection;
use elite42\trackpms\types\collection\reservationNoteCollection;
use elite42\trackpms\types\collection\reservationRateCollection;
use elite42\trackpms\types\collection\reservationTypeCollection;
use elite42\trackpms\types\collection\roleCollection;
use elite42\trackpms\types\collection\unitBlockCollection;
use elite42\trackpms\types\collection\unitRoleCollection;
use elite42\trackpms\types\collection\unitCollection;
use elite42\trackpms\types\collection\userCollection;
use elite42\trackpms\types\company;
use elite42\trackpms\types\companyAttachment;
use elite42\trackpms\types\contract;
use elite42\trackpms\types\customField;
use elite42\trackpms\types\itemCategory;
use elite42\trackpms\types\maintenanceWorkOrder;
use elite42\trackpms\types\owner;
use elite42\trackpms\types\ownerUnit;
use elite42\trackpms\types\reservation;
use elite42\trackpms\types\reservationAttachment;
use elite42\trackpms\types\reservationFee;
use elite42\trackpms\types\reservationNote;
use elite42\trackpms\types\reservationRate;
use elite42\trackpms\types\reservationType;
use elite42\trackpms\types\role;
use elite42\trackpms\types\unitBlock;
use elite42\trackpms\types\unitRole;
use elite42\trackpms\types\unit;
use elite42\trackpms\types\user;
use GuzzleHttp\Exception\GuzzleException;


class trackApi {

	private trackApiSettings $settings;

	private \Monolog\Logger  $logger;

	private trackApiCache    $cache;


	public function __construct( trackApiSettings $settings ) {
		$this->settings = $settings;

		//log setup
		if( $settings->isDebugLogging() ) {
			$logChannel = 'elite42.trckpms';

			// Create the logger
			$this->logger = new \Monolog\Logger( $logChannel );

			// save the log entries to a file
			$this->logger->pushHandler( new \Monolog\Handler\StreamHandler( trim( $settings->getDebugLogPath(), '/\\' ) . '/' . $logChannel . '.log', \Monolog\Logger::DEBUG ) );

			//enable debugging on json deserialize
			\andrewsauder\jsonDeserialize\config::setDebugLogPath( $settings->getDebugLogPath() );
			\andrewsauder\jsonDeserialize\config::setDebugLogging( true );
			\andrewsauder\jsonDeserialize\config::setLogJsonMissingProperty( false );
		}

		if( $settings->isEnableCaching() ) {
			$this->cache = new trackApiCache( $settings->getCachePath() );
		}
	}


	private function buildUrl( string $url, array $queryParams = [] ) : string {
		$finalUrl = $url;

		if( count( $queryParams ) > 0 ) {
			$appendJoiner = '?';
			if( str_contains( $url, '?' ) ) {
				$appendJoiner = '&';
			}

			$finalUrl .= $appendJoiner . http_build_query( $queryParams );
		}

		return $finalUrl;
	}


	/**
	 * Perform a single API call
	 *
	 * @param  string    $httpMethod  HTTP Method to use
	 * @param  string    $apiUrl      Ex: /pms/units?sortColumn=name&sortDirection=asc
	 * @param  string[]  $params      [optional] Associative array of parameters to pass. DO NOT INCLUDE TOKENS!
	 *
	 * @return mixed
	 * @throws \elite42\trackpms\trackException
	 */
	public function call( string $httpMethod, string $apiUrl, array $params = [] ) : mixed {
		if( str_starts_with( $apiUrl, 'http' ) ) {
			$callUrl = $apiUrl;
		}
		else {
			$callUrl = $this->settings->getUrl() . $apiUrl;
		}

		//check the runtime cache and return its value if not null
		if( $this->settings->isEnableCaching() && strtoupper( $httpMethod ) == 'GET' ) {
			$cacheResponse = $this->cache->get( 'track', $callUrl, $params );
			if( $cacheResponse !== null ) {
				if( $this->settings->isDebugLogging() ) {
					$this->logger->debug( $httpMethod . ' [cached]: ' . $apiUrl, $params );
				}

				return $cacheResponse;
			}
		}

		if( $this->settings->isDebugLogging() ) {
			$this->logger->debug( $httpMethod . ': ' . $apiUrl, $params );
		}

		$client = new \GuzzleHttp\Client();

		$options = [
			'headers' => [
				'Accept' => 'application/json',
			],
			'auth'    => [
				$this->settings->getKey(),
				$this->settings->getSecret()
			]
		];

		if( count( $params ) > 0 ) {
			if( strtoupper( $httpMethod ) === 'GET' ) {
				$options[ 'query' ] = $params;
			}
			elseif( strtoupper( $httpMethod ) === 'POST' ) {
				$options[ 'json' ] = $params;
			}
			elseif( strtoupper( $httpMethod ) === 'PUT' ) {
				$options[ 'json' ] = $params;
			}
			elseif( strtoupper( $httpMethod ) === 'PATCH' ) {
				$options[ 'json' ] = $params;
			}
			elseif( strtoupper( $httpMethod ) === 'DELETE' ) {
				$options[ 'query' ] = $params;
			}
		}

		try {
			$response = $client->request( strtoupper( $httpMethod ), $callUrl, $options );

			$body = new \stdClass();
			if($response->getStatusCode()==200) {
				$body = json_decode( $response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR );
			}

			//set api cache
			if( $this->settings->isEnableCaching() && strtoupper( $httpMethod ) == 'GET' ) {
				$this->logger->debug( 'Create cache ' . $httpMethod . ': ' . $apiUrl, $params );
				$this->cache->set( 'track', $callUrl, $params, $body );
			}

			return $body;
		}
		catch( GuzzleException $e ) {
			throw new trackException( $e->getMessage(), $e->getCode(), $e );
		}
		catch( \JsonException $e ) {
			throw new trackException( $e->getMessage(), $e->getCode(), $e );
		}
	}


	/**
	 * Perform an API call that will follow top level paging 'next' links until all pages have been requested
	 * Returns an array where each value is an API response. Array is returned even if there is only one page of results
	 *
	 * @param  string    $httpMethod    HTTP Method to use
	 * @param  string    $apiUrl        Ex: /pms/units
	 * @param  string[]  $params        Associative array of parameters to pass as json or query params
	 * @param  array     $apiResponses  Used by the function for recursion - ignore
	 *
	 * @return array
	 * @throws \elite42\trackpms\trackException
	 */
	public function callAndFollowPaging( string $httpMethod, string $apiUrl, array $params = [], array $apiResponses = [] ) : array {
		$apiResponse = $this->call( $httpMethod, $apiUrl, $params );

		$apiResponses[] = $apiResponse;

		if( isset( $apiResponse->_links?->next?->href ) ) {
			return $this->callAndFollowPaging( $httpMethod, $apiResponse->_links->next->href, $params, $apiResponses );
		}

		return $apiResponses;
	}


	/**
	 * @param  int  $unitId
	 *
	 * @return \elite42\trackpms\types\unit
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnit( int $unitId ) : types\unit {
		$url = $this->buildUrl( '/pms/units/' . $unitId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return unit::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\unit', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getunits
	 *
	 * @return \elite42\trackpms\types\unit[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnits( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units', $queryParams );

		/** @var \elite42\trackpms\types\collection\unitCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$units = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->units ) ) {
					foreach( $apiResponse->_embedded?->units as $unit ) {
						$units[] = unit::jsonDeserialize( $unit );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\unit', 500, $e );
		}

		return $units;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getunits
	 *
	 * @return \elite42\trackpms\types\collection\unitCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$unitCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$unitCollections[] = unitCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\unitCollection', 500, $e );
			}
		}

		return $unitCollections;
	}


	/**
	 * @param  int  $reservationId
	 *
	 * @return \elite42\trackpms\types\reservation
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservation( int $reservationId ) : types\reservation {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return reservation::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservation', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getreservations. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\reservation[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservations( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/reservations', $queryParams );

		/** @var \elite42\trackpms\types\collection\reservationCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservations = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->reservations ) ) {
					foreach( $apiResponse->_embedded?->reservations as $reservation ) {
						$reservations[] = reservation::jsonDeserialize( $reservation );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservation', 500, $e );
		}

		return $reservations;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getreservations. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\reservationCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/reservations', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$reservationCollections[] = reservationCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationCollection', 500, $e );
			}
		}

		return $reservationCollections;
	}


	/**
	 * @param  int  $reservationId
	 * @param  int  $reservationFeeId
	 *
	 * @return \elite42\trackpms\types\reservationFee
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationFee( int $reservationId, int $reservationFeeId ) : types\reservationFee {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/fees/' . $reservationFeeId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return reservationFee::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationFee', 500, $e );
		}
	}


	/**
	 * @param  int  $reservationId
	 *
	 * @return \elite42\trackpms\types\reservationFee[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationFees( int $reservationId ) : array {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/fees' );

		/** @var \elite42\trackpms\types\collection\reservationFeeCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationFees = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->fees ) ) {
					foreach( $apiResponse->_embedded?->fees as $reservationFee ) {
						$reservationFees[] = reservationFee::jsonDeserialize( $reservationFee );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationFee', 500, $e );
		}

		return $reservationFees;
	}


	/**
	 * @param  int  $reservationId
	 *
	 * @return \elite42\trackpms\types\collection\reservationFeeCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationFeeCollections( int $reservationId ) : array {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/fees' );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationFeeCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$reservationFeeCollections[] = reservationFeeCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationFeeCollection', 500, $e );
			}
		}

		return $reservationFeeCollections;
	}


	/**
	 * @param  int  $reservationId
	 *
	 * @return \elite42\trackpms\types\reservationNote[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationRates( int $reservationId ) : array {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/rates' );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationRates = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->rates ) ) {
					foreach( $apiResponse->rates as $reservationRate ) {
						$reservationRates[] = reservationRate::jsonDeserialize( $reservationRate );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationNote', 500, $e );
		}

		return $reservationRates;
	}


	/**
	 * @param  int  $reservationId
	 * @param  int  $reservationNoteId
	 *
	 * @return \elite42\trackpms\types\reservationNote
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationNote( int $reservationId, int $reservationNoteId ) : types\reservationNote {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/notes/' . $reservationNoteId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return reservationNote::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationNote', 500, $e );
		}
	}


	/**
	 * @param  int  $reservationId
	 *
	 * @return \elite42\trackpms\types\reservationNote[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationNotes( int $reservationId ) : array {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/notes' );

		/** @var \elite42\trackpms\types\collection\reservationNoteCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationNotes = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->notes ) ) {
					foreach( $apiResponse->_embedded?->notes as $reservationNote ) {
						$reservationNotes[] = reservationNote::jsonDeserialize( $reservationNote );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationNote', 500, $e );
		}

		return $reservationNotes;
	}


	/**
	 * @param  int  $reservationId
	 *
	 * @return \elite42\trackpms\types\collection\reservationNoteCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationNoteCollections( int $reservationId ) : array {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/notes' );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationNoteCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$reservationNoteCollections[] = reservationNoteCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationNoteCollection', 500, $e );
			}
		}

		return $reservationNoteCollections;
	}


	/**
	 * @param  int  $amenityId
	 *
	 * @return \elite42\trackpms\types\amenity
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAmenity( int $amenityId ) : types\amenity {
		$url = $this->buildUrl( '/pms/units/amenities/' . $amenityId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return amenity::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\amenity', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getunitamenities. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\amenity[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAmenities( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units/amenities', $queryParams );

		/** @var \elite42\trackpms\types\collection\amenityCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$amenities = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->amenities ) ) {
					foreach( $apiResponse->_embedded?->amenities as $amenity ) {
						$amenities[] = amenity::jsonDeserialize( $amenity );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\amenity', 500, $e );
		}

		return $amenities;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getamenities. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\amenityCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAmenityCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units/amenities', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$amenityCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$amenityCollections[] = amenityCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\amenityCollection', 500, $e );
			}
		}

		return $amenityCollections;
	}


	/**
	 * @param  int  $amenityGroupId
	 *
	 * @return \elite42\trackpms\types\amenityGroup
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAmenityGroup( int $amenityGroupId ) : types\amenityGroup {
		$url = $this->buildUrl( '/pms/units/amenity-groups/' . $amenityGroupId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return amenityGroup::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\amenityGroup', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getunitamenitygroups. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\amenityGroup[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAmenityGroups( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units/amenity-groups', $queryParams );

		/** @var \elite42\trackpms\types\collection\amenityGroupCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$amenityGroupGroups = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->amenitiesCategory ) ) {
					foreach( $apiResponse->_embedded?->amenitiesCategory as $amenityGroup ) {
						$amenityGroupGroups[] = amenityGroup::jsonDeserialize( $amenityGroup );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\amenityGroup', 500, $e );
		}

		return $amenityGroupGroups;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getunitamenitygroups. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\amenityGroupCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAmenityGroupCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units/amenity-groups', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$amenityGroupCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$amenityGroupCollections[] = amenityGroupCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\amenityGroupCollection', 500, $e );
			}
		}

		return $amenityGroupCollections;
	}


	/**
	 * @param  int  $customFieldId
	 *
	 * @return \elite42\trackpms\types\customField
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCustomField( int $customFieldId ) : customField {
		$url = $this->buildUrl( '/custom-fields/' . $customFieldId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return customField::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\customField', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcustomfields. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\customField[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCustomFields( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/custom-fields', $queryParams );

		/** @var \elite42\trackpms\types\collection\customFieldCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$customFields = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->customFields ) ) {
					foreach( $apiResponse->_embedded?->customFields as $customField ) {
						$customFields[] = customField::jsonDeserialize( $customField );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\customField', 500, $e );
		}

		return $customFields;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcustomfields. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\customFieldCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCustomFieldCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/custom-fields', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$customFieldCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$customFieldCollections[] = customFieldCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\customFieldCollection', 500, $e );
			}
		}

		return $customFieldCollections;
	}


	/**
	 * @param  int  $maintenanceWorkOrderId
	 *
	 * @return \elite42\trackpms\types\maintenanceWorkOrder
	 * @throws \elite42\trackpms\trackException
	 */
	public function getMaintenanceWorkOrder( int $maintenanceWorkOrderId ) : maintenanceWorkOrder {
		$url = $this->buildUrl( '/pms/maintenance/work-orders/' . $maintenanceWorkOrderId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return maintenanceWorkOrder::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\maintenanceWorkOrder', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getmaintworkorders. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\maintenanceWorkOrder[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getMaintenanceWorkOrders( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/maintenance/work-orders', $queryParams );

		/** @var \elite42\trackpms\types\collection\maintenanceWorkOrderCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$maintenanceWorkOrders = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->workOrders ) ) {
					foreach( $apiResponse->_embedded?->workOrders as $maintenanceWorkOrder ) {
						$maintenanceWorkOrders[] = maintenanceWorkOrder::jsonDeserialize( $maintenanceWorkOrder );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\maintenanceWorkOrder', 500, $e );
		}

		return $maintenanceWorkOrders;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getmaintworkorders. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\maintenanceWorkOrderCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getMaintenanceWorkOrderCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/maintenance/work-orders', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$maintenanceWorkOrderCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$maintenanceWorkOrderCollections[] = maintenanceWorkOrderCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\maintenanceWorkOrderCollection', 500, $e );
			}
		}

		return $maintenanceWorkOrderCollections;
	}


	/**
	 * @param  int  $ownerId
	 *
	 * @return \elite42\trackpms\types\owner
	 * @throws \elite42\trackpms\trackException
	 */
	public function getOwner( int $ownerId ) : owner {
		$url = $this->buildUrl( '/pms/owners/' . $ownerId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return owner::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\owner', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getownercollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\owner[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getOwners( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/owners', $queryParams );

		/** @var \elite42\trackpms\types\collection\ownerCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$owners = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->owners ) ) {
					foreach( $apiResponse->_embedded?->owners as $owner ) {
						$owners[] = owner::jsonDeserialize( $owner );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\owner', 500, $e );
		}

		return $owners;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getownercollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\ownerCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getOwnerCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/owners', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$ownerCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$ownerCollections[] = ownerCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\ownerCollection', 500, $e );
			}
		}

		return $ownerCollections;
	}


	/**
	 * @param  int  $companyId
	 *
	 * @return \elite42\trackpms\types\company
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCompany( int $companyId ) : company {
		$url = $this->buildUrl( '/crm/companies/' . $companyId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return company::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\company', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcompanycollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\company[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCompanies( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/crm/companies', $queryParams );

		/** @var \elite42\trackpms\types\collection\companyCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$companies = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->companies ) ) {
					foreach( $apiResponse->_embedded?->companies as $company ) {
						$companies[] = company::jsonDeserialize( $company );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\company', 500, $e );
		}

		return $companies;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcompanycollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\companyCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCompanyCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/crm/companies', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$companyCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$companyCollections[] = companyCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\companyCollection', 500, $e );
			}
		}

		return $companyCollections;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getownerUnitcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\ownerUnit[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getOwnerUnits( int $ownerId, array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/owners/' . $ownerId . '/units', $queryParams );

		/** @var \elite42\trackpms\types\collection\ownerUnitCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$ownerUnits = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->ownerUnits ) ) {
					foreach( $apiResponse->_embedded?->ownerUnits as $ownerUnit ) {
						$ownerUnits[] = ownerUnit::jsonDeserialize( $ownerUnit );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\ownerUnit', 500, $e );
		}

		return $ownerUnits;
	}


	/**
	 * @param  int  $contractId
	 *
	 * @return \elite42\trackpms\types\contract
	 * @throws \elite42\trackpms\trackException
	 */
	public function getContract( int $contractId ) : contract {
		$url = $this->buildUrl( '/pms/owners/contracts/' . $contractId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return contract::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\contract', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcontractcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\contract[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getContracts( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/owners/contracts', $queryParams );

		/** @var \elite42\trackpms\types\collection\contractCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$contracts = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->contracts ) ) {
					foreach( $apiResponse->_embedded?->contracts as $contract ) {
						$contracts[] = contract::jsonDeserialize( $contract );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\contract', 500, $e );
		}

		return $contracts;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcontractcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\contractCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getContractCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/owners/contracts', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$contractCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$contractCollections[] = contractCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\contractCollection', 500, $e );
			}
		}

		return $contractCollections;
	}


	/**
	 * @param  int  $unitRoleId
	 *
	 * @return \elite42\trackpms\types\unitRole
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitRole( int $unitRoleId ) : unitRole {
		$url = $this->buildUrl( '/pms/units/roles/' . $unitRoleId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return unitRole::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\role', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getrolecollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\unitRole[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitRoles( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units/roles', $queryParams );

		/** @var \elite42\trackpms\types\collection\unitRoleCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$roles = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->unitRoles ) ) {
					foreach( $apiResponse->_embedded?->unitRoles as $role ) {
						$roles[] = unitRole::jsonDeserialize( $role );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\role', 500, $e );
		}

		return $roles;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getrolecollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\unitRoleCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitRoleCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/units/roles', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$roleCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$roleCollections[] = unitRoleCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\roleCollection', 500, $e );
			}
		}

		return $roleCollections;
	}


	/**
	 * @param  int  $userId
	 *
	 * @return \elite42\trackpms\types\unitRole
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUser( int $userId ) : unitRole {
		$url = $this->buildUrl( '/user/' . $userId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return user::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\user', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\user[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUsers( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/users', $queryParams );

		/** @var \elite42\trackpms\types\collection\userCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$users = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->users ) ) {
					foreach( $apiResponse->_embedded?->users as $user ) {
						$users[] = user::jsonDeserialize( $user );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\user', 500, $e );
		}

		return $users;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\userCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUserCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/users', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$userCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$userCollections[] = userCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\userCollection', 500, $e );
			}
		}

		return $userCollections;
	}


	/**
	 * @param  int  $roleId
	 *
	 * @return \elite42\trackpms\types\unitRole
	 * @throws \elite42\trackpms\trackException
	 */
	public function getRole( int $roleId ) : unitRole {
		$url = $this->buildUrl( '/role/' . $roleId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return role::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\role', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\role[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getRoles( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/roles', $queryParams );

		/** @var \elite42\trackpms\types\collection\roleCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$roles = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->roles ) ) {
					foreach( $apiResponse->_embedded?->roles as $role ) {
						$roles[] = role::jsonDeserialize( $role );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\role', 500, $e );
		}

		return $roles;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getrolecollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\roleCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getRoleCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/roles', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$roleCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$roleCollections[] = roleCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\roleCollection', 500, $e );
			}
		}

		return $roleCollections;
	}


	/**
	 * @param  int  $reservationTypeId
	 *
	 * @return \elite42\trackpms\types\reservationType
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationType( int $reservationTypeId ) : reservationType {
		$url = $this->buildUrl( '/pms/reservations/types/' . $reservationTypeId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return reservationType::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationType', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\reservationType[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationTypes( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/reservations/types', $queryParams );

		/** @var \elite42\trackpms\types\collection\reservationTypeCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationTypes = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->reservationTypes ) ) {
					foreach( $apiResponse->_embedded?->reservationTypes as $reservationType ) {
						$reservationTypes[] = reservationType::jsonDeserialize( $reservationType );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationType', 500, $e );
		}

		return $reservationTypes;
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getreservationTypecollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\reservationTypeCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationTypeCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/reservations/types', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationTypeCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$reservationTypeCollections[] = reservationTypeCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationTypeCollection', 500, $e );
			}
		}

		return $reservationTypeCollections;
	}


	/**
	 * @param  int  $companyId
	 * @param  int  $attachmentId
	 *
	 * @return \elite42\trackpms\types\companyAttachment
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCompanyAttachment( int $companyId, int $attachmentId ) : companyAttachment {
		$url = $this->buildUrl( '/crm/companies/' . $companyId . '/attachments/' . $attachmentId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return companyAttachment::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\companyAttachment', 500, $e );
		}
	}


	/**
	 * @param  int    $companyId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\companyAttachment[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCompanyAttachments( int $companyId, array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/crm/companies/' . $companyId . '/attachments', $queryParams );

		/** @var \elite42\trackpms\types\collection\companyAttachmentCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$companyAttachments = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->attachments ) ) {
					foreach( $apiResponse->_embedded?->attachments as $companyAttachment ) {
						$companyAttachments[] = companyAttachment::jsonDeserialize( $companyAttachment );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\companyAttachment', 500, $e );
		}

		return $companyAttachments;
	}


	/**
	 * @param  int    $companyId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcompanyAttachmentcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\companyAttachmentCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getCompanyAttachmentCollections( int $companyId, array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/crm/companies/' . $companyId . '/attachments', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$companyAttachmentCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$companyAttachmentCollections[] = companyAttachmentCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\companyAttachmentCollection', 500, $e );
			}
		}

		return $companyAttachmentCollections;
	}



	/**
	 * @param  int  $unitBlockId
	 *
	 * @return \elite42\trackpms\types\unitBlock
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitBlock( int $unitBlockId ) : unitBlock {
		$url = $this->buildUrl( '/pms/unit-blocks/' . $unitBlockId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return unitBlock::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\unitBlock', 500, $e );
		}
	}


	/**
	 * @param  int    $companyId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\unitBlock[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitBlocks( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/unit-blocks', $queryParams );

		/** @var \elite42\trackpms\types\collection\unitBlockCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$unitBlocks = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->unitBlocks ) ) {
					foreach( $apiResponse->_embedded?->unitBlocks as $unitBlock ) {
						$unitBlocks[] = unitBlock::jsonDeserialize( $unitBlock );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\unitBlock', 500, $e );
		}

		return $unitBlocks;
	}


	/**
	 * @param  int    $companyId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getunitBlockcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\unitBlockCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getUnitBlockCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/unit-blocks', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$unitBlockCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$unitBlockCollections[] = unitBlockCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\unitBlockCollection', 500, $e );
			}
		}

		return $unitBlockCollections;
	}


	/**
	 * @param  int     $companyId
	 * @param  string  $fileData  Base 64 encoded data
	 * @param  string  $name      Attachment name, will default to file name if empty string
	 * @param  bool    $isPublic
	 * @param  string  $originalFilename
	 *
	 * @return \elite42\trackpms\types\companyAttachment
	 * @throws \elite42\trackpms\trackException
	 */
	public function createCompanyAttachment( int $companyId, string $fileData, string $name, bool $isPublic, string $originalFilename ) : companyAttachment {
		$url = $this->buildUrl( '/crm/companies/' . $companyId . '/attachments' );

		$body = [
			'fileData'         => $fileData,
			'name'             => $name,
			'isPublic'         => $isPublic,
			'originalFilename' => $originalFilename
		];

		$apiResponse = $this->call( 'POST', $url, $body );

		try {
			return companyAttachment::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\companyAttachment', 500, $e );
		}
	}


	/**
	 * @param  int     $companyId
	 * @param  int     $attachmentId
	 * @param  string  $name  Attachment name, will default to file name if empty string
	 * @param  bool    $isPublic
	 *
	 * @return \elite42\trackpms\types\companyAttachment
	 * @throws \elite42\trackpms\trackException
	 */
	public function updateCompanyAttachment( int $companyId, int $attachmentId, string $name, bool $isPublic ) : companyAttachment {
		$url = $this->buildUrl( '/crm/companies/' . $companyId . '/attachments/'. $attachmentId );

		$body = [
			'name'             => $name,
			'isPublic'         => $isPublic
		];

		$apiResponse = $this->call( 'PATCH', $url, $body );

		try {
			return companyAttachment::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\companyAttachment', 500, $e );
		}
	}


	/**
	 * @param  int     $companyId
	 * @param  int     $attachmentId
	 *
	 * @return bool
	 * @throws \elite42\trackpms\trackException
	 */
	public function deleteCompanyAttachment( int $companyId, int $attachmentId ) : bool {
		$url = $this->buildUrl( '/crm/companies/' . $companyId . '/attachments/'. $attachmentId );

		$apiResponse = $this->call( 'DELETE', $url );

		return true;
	}


	/**
	 * @param  int    $reservationId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/discuss/61fd3729f5da3f029bb47f4c. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\reservationAttachment[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationAttachments( int $reservationId, array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/reservations/'.$reservationId.'/attachments', $queryParams );

		/** @var \elite42\trackpms\types\collection\reservationAttachmentCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationAttachments = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->attachments ) ) {
					foreach( $apiResponse->_embedded?->attachments as $reservationAttachment ) {
						$reservationAttachments[] = reservationAttachment::jsonDeserialize( $reservationAttachment );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationAttachment', 500, $e );
		}

		return $reservationAttachments;
	}


	/**
	 * @param  int    $reservationId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getreservationAttachmentcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\reservationAttachmentCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getReservationAttachmentCollections( int $reservationId, array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/reservations/'.$reservationId.'/attachments', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$reservationAttachmentCollections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$reservationAttachmentCollections[] = reservationAttachmentCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationAttachmentCollection', 500, $e );
			}
		}

		return $reservationAttachmentCollections;
	}

	/**
	 * @param int    $reservationId
	 * @param string $fileData Base 64 encoded data
	 * @param string $name     Attachment name, will default to file name if empty string
	 * @param string $type     'attachment', 'agreement'
	 * @param string $originalFilename
	 *
	 * @return \elite42\trackpms\types\reservationAttachment
	 * @throws \elite42\trackpms\trackException
	 */
	public function createReservationAttachment( int $reservationId, string $fileData, string $name, string $type, string $originalFilename ) : reservationAttachment {
		$url = $this->buildUrl( '/pms/reservations/'.$reservationId.'/attachments' );

		$body = [
			'fileData'         => $fileData,
			'name'             => $name,
			'type'             => $type,
			'originalFilename' => $originalFilename
		];

		$apiResponse = $this->call( 'POST', $url, $body );

		try {
			return reservationAttachment::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationAttachment', 500, $e );
		}
	}


	/**
	 * @param  int     $reservationId
	 * @param  int     $attachmentId
	 * @param  string  $name  Attachment name, will default to file name if empty string
	 *
	 * @return \elite42\trackpms\types\reservationAttachment
	 * @throws \elite42\trackpms\trackException
	 */
	public function updateReservationAttachment( int $reservationId, int $attachmentId, string $name ) : reservationAttachment {
		$url = $this->buildUrl( '/pms/reservations/'.$reservationId.'/attachments/'. $attachmentId );

		$body = [
			'name'             => $name
		];

		$apiResponse = $this->call( 'PATCH', $url, $body );

		try {
			return reservationAttachment::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationAttachment', 500, $e );
		}
	}


	/**
	 * @param  int     $reservationId
	 * @param  int     $attachmentId
	 *
	 * @return bool
	 * @throws \elite42\trackpms\trackException
	 */
	public function deleteReservationAttachment( int $reservationId, int $attachmentId ) : bool {
		$url = $this->buildUrl( '/pms/reservations/' . $reservationId . '/attachments/'. $attachmentId );

		$apiResponse = $this->call( 'DELETE', $url );

		return true;
	}

	/**
	 * @param  int  $categoryId
	 *
	 * @return \elite42\trackpms\types\company
	 * @throws \elite42\trackpms\trackException
	 */
	public function getItemCategory( int $categoryId ) : company {
		$url = $this->buildUrl( '/pms/accounting/items/categories/' . $categoryId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return itemCategory::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\itemCategory', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcompanycollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\company[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getItemCategories( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/accounting/items/categories', $queryParams );

		/** @var \elite42\trackpms\types\collection\itemCategoryCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$companies = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->categories ) ) {
					foreach( $apiResponse->_embedded?->categories as $company ) {
						$companies[] = itemCategory::jsonDeserialize( $company );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\company', 500, $e );
		}

		return $companies;
	}

	/**
	 * @param  int    $catId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getreservationAttachmentcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\reservationAttachmentCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getItemCategoryCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/accounting/items/categories', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$collections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$collections[] = itemCategoryCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationAttachmentCollection', 500, $e );
			}
		}

		return $collections;
	}

	/**
	 * @param  int  $accountId
	 *
	 * @return \elite42\trackpms\types\company
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAccount( int $accountId ) : company {
		$url = $this->buildUrl( '/pms/accounting/accounts/' . $accountId );

		$apiResponse = $this->call( 'GET', $url );

		try {
			return account::jsonDeserialize( $apiResponse );
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\account', 500, $e );
		}
	}


	/**
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getcompanycollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\company[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAccounts( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/accounting/accounts', $queryParams );

		/** @var \elite42\trackpms\types\collection\accountCollection[] $apiResponses */
		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$companies = [];
		try {
			foreach( $apiResponses as $apiResponse ) {
				if( isset( $apiResponse->_embedded?->accounts ) ) {
					foreach( $apiResponse->_embedded?->accounts as $company ) {
						$companies[] = account::jsonDeserialize( $company );
					}
				}
			}
		}
		catch( jsonDeserializeException $e ) {
			throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\company', 500, $e );
		}

		return $companies;
	}

	/**
	 * @param  int    $catId
	 * @param  array  $queryParams  Key value pairs of track api query params https://developer.trackhs.com/reference/getreservationAttachmentcollection. Ex: [ 'size'=>100, 'unitId'=>139 ]
	 *
	 * @return \elite42\trackpms\types\collection\reservationAttachmentCollection[]
	 * @throws \elite42\trackpms\trackException
	 */
	public function getAccountCollections( array $queryParams = [] ) : array {
		$url = $this->buildUrl( '/pms/accounting/accounts', $queryParams );

		$apiResponses = $this->callAndFollowPaging( 'GET', $url );

		$collections = [];

		foreach( $apiResponses as $apiResponse ) {
			try {
				$collections[] = accountCollection::jsonDeserialize( $apiResponse );
			}
			catch( jsonDeserializeException $e ) {
				throw new trackException( 'Failed to convert JSON API response to \elite42\trackpms\types\reservationAttachmentCollection', 500, $e );
			}
		}

		return $collections;
	}
}