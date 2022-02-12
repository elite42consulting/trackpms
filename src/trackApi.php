<?php
namespace elite42\trackpms;

use GuzzleHttp\Exception\GuzzleException;

class trackApi {

	private trackApiSettings $settings;

	private \Monolog\Logger $logger;

	private trackApiCache $cache;

	function __construct( trackApiSettings $settings ) {
		$this->settings = $settings;

		//log setup
		if( $settings->isDebugLogging() ) {
			$logChannel = 'elite42.trckpms';

			// Create the logger
			$this->logger = new \Monolog\Logger( $logChannel );

			// save the log entries to a file
			$this->logger->pushHandler( new \Monolog\Handler\StreamHandler( trim( $settings->getDebugLogPath(), '/\\' ) . '/' . $logChannel . '.log', \Monolog\Logger::DEBUG ) );
		}

		if( $settings->isEnableCaching()){
			$this->cache = new trackApiCache( $settings->getCachePath() );
		}

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

		$callUrl = $this->settings->getUrl() . $apiUrl;

		//check the runtime cache and return its value if not null
		if( $this->settings->isEnableCaching() && strtoupper( $httpMethod ) == 'GET' ) {
			$cacheResponse = $this->cache->get( 'track', $callUrl, $params );
			if( $cacheResponse !== null ) {
				if($this->settings->isDebugLogging()) {
					$this->logger->debug( $httpMethod . ' [cached]: ' . $apiUrl, $params);
				}
				return $cacheResponse;
			}
		}

		if($this->settings->isDebugLogging()) {
			$this->logger->debug( $httpMethod . ': ' . $apiUrl, $params);
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
				$this->logger->debug( 'Create cache '. $httpMethod . ': ' . $apiUrl, $params);
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
	 *
	 * Returns an array where each value is an API response. Array is returned even if there is only one page of results
	 *
	 * @param  string    $httpMethod   HTTP Method to use
	 * @param  string    $apiUrl       Ex: /pms/units
	 * @param  string[]  $params       Associative array of parameters to pass as json or query params
	 * @param  array     $apiResponses Used by the function for recursion - ignore
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


	public function getU() {

	}
}