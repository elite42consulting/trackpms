# TRACK Property Management System PHP SDK
PHP SDK library for [Track Pulse API](https://developer.trackhs.com/reference/)

***This SDK is not created or supported by Track***

---

## Requirements
- Requires Composer for installation
- Requires &gt;=PHP 8

---

## Installation
`composer require elite42/trackpms`

---

## Example Usage
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
    $unit            = $api->getUnit( 145 );
    $unitCollections = $api->getUnitCollections( );
    $units           = $api->getUnits( [ 'size'=>100 ] );

    $reservation            = $api->getReservation( 1 );
    $reservations           = $api->getReservations( [ 'size' => 100 ] );
    $reservationCollections = $api->getReservationCollections( [ 'size' => 100 ] );
    
    $amenity = $api->getAmenity( 1 );
    $amenities = $api->getAmenities( [ 'size' => 100 ] );
    $amenityCollections = $api->getAmenityCollections( [ 'size' => 100 ] );
    
    $amenityGroup            = $api->getAmenityGroup( 1 );
    $amenityGroups           = $api->getAmenityGroups( [ 'size' => 100 ] );
    $amenityGroupCollections = $api->getAmenityGroupCollections( [ 'size' => 100 ] );
    
    $customField            = $api->getCustomField( 1 );
	$customFields           = $api->getCustomFields( [ 'size' => 100 ] );
	$customFieldCollections = $api->getCustomFieldCollections( [ 'size' => 100 ] );
	
	$maintenanceWorkOrder            = $api->getMaintenanceWorkOrder( 3 );
    $maintenanceWorkOrders           = $api->getMaintenanceWorkOrders( [ 'size' => 100 ] );
    $maintenanceWorkOrderCollections = $api->getMaintenanceWorkOrderCollections( [ 'size' => 100 ] );
}
catch( \elite42\trackpms\trackException $e ) {
    throw new controllerException( 'Error while running API command: '.$e->getMessage(), 400, $e);
}
```
---

## Methods

### Units
| Fetch        | API Method                                                                               |
|--------------|------------------------------------------------------------------------------------------|
| One Unit     | `$api->getUnit( int $unitId )`                                                           |
| Many Units   | `$api->getUnits( array $queryParams )`                                                   |
| Collection   | `$api->getUnitCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getunits

---

### Reservations
| Fetch             | API Method                                                                                      |
|-------------------|-------------------------------------------------------------------------------------------------|
| One Reservation   | `$api->getReservation( int $reservationId )`                                                    |
| Many Reservations | `$api->getReservations( array $queryParams )`                                                   |
| Collection        | `$api->getReservationCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getreservations

---

### Amenities
| Fetch          | API Method                                                                                  |
|----------------|---------------------------------------------------------------------------------------------|
| One Amenity    | `$api->getAmenity( int $amenityId )`                                                        |
| Many Amenities | `$api->getAmenities( array $queryParams )`                                                  |
| Collection     | `$api->getAmenityCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getunitamenities

---

### Amenity Groups
| Fetch               | API Method                                                                                       |
|---------------------|--------------------------------------------------------------------------------------------------|
| One Amenity Group   | `$api->getAmenityGroup( int $amenityGroupId )`                                                   |
| Many Amenity Group  | `$api->getAmenityGroups( array $queryParams )`                                                   |
| Collection          | `$api->getAmenityGroupCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getunitamenitygroups

---

### Custom Fields
| Fetch              | API Method                                                                                      |
|--------------------|-------------------------------------------------------------------------------------------------|
| One Custom Field   | `$api->getCustomField( int $customFieldId )`                                                    |
| Many Custom Fields | `$api->getCustomFields( array $queryParams )`                                                   |
| Collection         | `$api->getCustomFieldCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getcustomfields

---

### Maintenance Work Orders
| Fetch      | API Method                                                                                               |
|------------|----------------------------------------------------------------------------------------------------------|
| One        | `$api->getMaintenanceWorkOrder( int $maintenanceWorkOrderId )`                                           |
| Many       | `$api->getMaintenanceWorkOrders( array $queryParams )`                                                   |
| Collection | `$api->getMaintenanceWorkOrderCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getmaintworkorders

---

### Manual Call to Track API
| Fetch              | API Method                                                                                    |
|--------------------|-----------------------------------------------------------------------------------------------|
| Call Once Only     | `$api->call( string $httpMethod, string $apiUrl, array $bodyParams=[] )`                      |
| Auto Follow Paging | `$api->callAndFollowPaging( string $httpMethod, string $apiUrl, array $bodyParams=[] )`       |

See available API URLs at https://developer.trackhs.com/reference/ 
Note that manual calls will not be parsed into models. The function will return the default output of `json_decode( $responseBody, false, 512, JSON_THROW_ON_ERROR )` 

