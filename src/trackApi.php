<?php
namespace elite42\trackpms;


use andrewsauder\jsonDeserialize\exceptions\jsonDeserializeException;
use elite42\trackpms\types\amenity;
use elite42\trackpms\types\amenityGroup;
use elite42\trackpms\types\collection\amenityCollection;
use elite42\trackpms\types\collection\amenityGroupCollection;
use elite42\trackpms\types\collection\contractCollection;
use elite42\trackpms\types\collection\customFieldCollection;
use elite42\trackpms\types\collection\maintenanceWorkOrderCollection;
use elite42\trackpms\types\collection\ownerCollection;
use elite42\trackpms\types\collection\ownerUnitCollection;
use elite42\trackpms\types\collection\reservationCollection;
use elite42\trackpms\types\collection\reservationFeeCollection;
use elite42\trackpms\types\collection\unitCollection;
use elite42\trackpms\types\contract;
use elite42\trackpms\types\customField;
use elite42\trackpms\types\maintenanceWorkOrder;
use elite42\trackpms\types\owner;
use elite42\trackpms\types\ownerUnit;
use elite42\trackpms\types\reservation;
use elite42\trackpms\types\reservationFee;
use elite42\trackpms\types\unit;
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

			$body = json_decode( $response->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR );

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

}