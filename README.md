# TRACK PMS PHP Integration
PHP integration library for Track Pulse

Requires &gt;=PHP 8

## Installation
`composer require elite42/trackpms`

## Usage
```php
$apiSettings = new \elite42\trackpms\trackApiSettings( 
    url          : '{url}',
    key          : '{key}',
    secret       : '{secret}',
    enableCaching: true,
    cachePath    : 'C:/inetpub/cache',
    debugLogging : true,
    debugLogPath : 'C:/inetpub/logs'
);

$api         = new \elite42\trackpms\trackApi( $apiSettings );

try {
    $unit = $api->getUnit( 145 );
    $unitCollections = $api->getUnitCollections( );
    $units = $api->getUnits( [ 'size'=>100 ] );

    $reservation = $api->getReservation( 1 );
    $reservations = $api->getReservations( [ 'size' => 100 ] );
    $reservationCollections = $api->getReservationCollections( [ 'size' => 100 ] );
}
catch( \elite42\trackpms\trackException $e ) {
    throw new controllerException( 'Error while running API command: '.$e->getMessage(), 400, $e);
}
```


## Methods
---
###Units
| Type        | API Method                                                                               |
|-------------|------------------------------------------------------------------------------------------|
| One Unit    | `$api->getUnit( int $unitId )`                                                           |
| Many Units  | `$api->getUnits( array $queryParams )`                                                   |
| Collection  | `$api->getUnitCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getunits

---

###Reservations
| Type        | API Method                                                                               |
|-------------|------------------------------------------------------------------------------------------|
| One Unit    | `$api->getReservation( int $reservationId )`                                                           |
| Many Units  | `$api->getReservations( array $queryParams )`                                                   |
| Collection  | `$api->getReservationCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getreservations
