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
		private string $debugLogPath  = '',
		private bool $enableDb=false,
		private string $dsn='',
		private string $readAccountUsername='',
		private string $readAccountPassword='',
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

		if($enableDb) {
			if( empty( trim( $dsn ) ) ) {
				throw new trackException( 'DB DSN required' );
			}
			if( empty( trim( $readAccountUsername ) ) ) {
				throw new trackException( 'DB read account username required' );
			}
			if( empty( trim( $readAccountPassword ) ) ) {
				throw new trackException( 'DB read account password required' );
			}
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

	public function isDbEnabled() : bool {
		return $this->enableDb;
	}

	public function getDsn() : string {
		return $this->dsn;
	}

	public function getReadAccountUsername() : string {
		return $this->readAccountUsername;
	}

	public function getReadAccountPassword() : string {
		return $this->readAccountPassword;
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
