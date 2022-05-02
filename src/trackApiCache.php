<?php
namespace elite42\trackpms;


/**
 * Runtime cache system
 */
class trackApiCache {

	private string $cacheFilePath = '';
	private array $collection = [];

	public function __construct( string $cacheFilePath) {
		$this->cacheFilePath = rtrim( $cacheFilePath, '/\\' );
	}





	public function set( $wsdl, $method, $params, $returnValue ) {

		$key = $this->generateKey( $wsdl, $method, $params );

		$this->collection[ $key ] = $returnValue;

		$fileName = $this->cacheFilePath.'/'.$key.'.cache';
		file_put_contents( $fileName, serialize($returnValue));
	}



	public function get( $wsdl, $method, $params, int $maxAgeInSeconds=-1 ) {

		$key = $this->generateKey( $wsdl, $method, $params );

		if ( isset( $this->collection[$key] ) ) {
			return $this->collection[$key];
		}

		$fileName = $this->cacheFilePath.'/'.$key.'.cache';
		if(file_exists($fileName)) {
			$allowCacheReturn = true;

			if($maxAgeInSeconds!==-1) {
				$cacheCreationDate = (new \DateTimeImmutable())->setTimestamp( filectime($fileName) );
				$oldestAllowedCacheDate = (new \DateTimeImmutable())->sub( new \DateInterval('PT'.$maxAgeInSeconds.'S'));
				if($cacheCreationDate>=$oldestAllowedCacheDate) {
					$allowCacheReturn = false;
				}
			}

			if( $allowCacheReturn) {
				$content = file_get_contents( $fileName );
				return unserialize( $content );
			}
		}

		return null;
	}



	private function generateKey( $wsdl, $method, $params ) : string {
		$strParams = json_encode($params);
		return md5( $wsdl . '.' . $method . '.' . $strParams );
	}


	private function sid( $unsafeString ) : string {
		$safeString = preg_replace("/[^A-Za-z0-9\-]/", '-', $unsafeString);
		$cleanSafeString = preg_replace("/-+/", '-', $safeString);
		return $cleanSafeString;
	}


}
