<?php

namespace elite42\trackpms;


class trackApiSettings {

	/**
	 * @param  string  $url
	 * @param  string  $key
	 * @param  string  $secret
	 * @param  bool    $enableCaching
	 * @param  string  $cachePath
	 * @param  bool    $debugLogging
	 * @param  string  $debugLogPath
	 *
	 * @throws \elite42\trackpms\trackException
	 */
	public function __construct(
		private string $url,
		private string $key,
		private string $secret,
		private bool   $enableCaching = false,
		private string $cachePath     = '',
		private bool   $debugLogging  = false,
		private string $debugLogPath  = ''
	) {
		if( empty( trim( $url, ' /' ) ) ) {
			throw new trackException( 'URL required' );
		}
		if( empty( trim( $key ) ) ) {
			throw new trackException( 'API key required' );
		}
		if( empty( trim( $secret ) ) ) {
			throw new trackException( 'API secret required' );
		}
		if( $enableCaching && empty( trim( $cachePath ) ) ) {
			throw new trackException( 'Cache path is required' );
		}

		$this->url    = rtrim( $url, '/' );
	}

	public function getUrl() : string {
		return $this->url;
	}

	public function getKey() : string {
		return $this->key;
	}

	public function getSecret() : string {
		return $this->secret;
	}

	public function isEnableCaching() : bool {
		return $this->enableCaching;
	}

	public function getCachePath() : string {
		return $this->cachePath;
	}

	public function isDebugLogging() : bool {
		return $this->debugLogging;
	}

	public function getDebugLogPath() : string {
		return $this->debugLogPath;
	}

}