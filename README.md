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
    
    $reservationFee = $api->getReservationFee( 1, 2 );
    $reservationFees = $api->getReservationFees( 1 );
    $reservationFeeCollections = $api->getReservationFeeCollections( 1 );
    
    $reservationNote = $api->getReservationNote( 1, 15 );
    $reservationNotes = $api->getReservationNotes( 1 );
    $reservationNoteCollections = $api->getReservationNoteCollections( 1 );
    
    $reservationRates = $api->getReservationRates( 1 );
    
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
    
    $owner            = $api->getOwner( 1000 );
    $owners           = $api->getOwners( [ 'size' => 100 ] );
    $ownerCollections = $api->getOwnerCollections( [ 'size' => 100 ] );
    $ownerUnits       = $api->getOwnerUnits( 1000 );
    
    $contract            = $api->getContract( 1 );
    $contracts           = $api->getContracts( [ 'size' => 100 ] );
    $contractCollections = $api->getContractCollections( [ 'size' => 100 ] );
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

### Reservation Fees
| Fetch                               | API Method                                                                                         |
|-------------------------------------|----------------------------------------------------------------------------------------------------|
| One Specific Reservation Fee        | `$api->getReservationFee( int $reservationId, int $reservationFeeId )`                             |
| All Fees for Reservation            | `$api->getReservationFees( int $reservationId )`                                                   |
| Collection of Fees for Reservation  | `$api->getReservationFeeCollections( int $reservationId )`<br/>*Provides full paged API responses* |

---

### Reservation Notes
| Fetch                               | API Method                                                                                          |
|-------------------------------------|-----------------------------------------------------------------------------------------------------|
| One Specific Reservation Note       | `$api->getReservationNote( int $reservationId, int $reservationFeeId )`                             |
| All Notes for Reservation           | `$api->getReservationNotes( int $reservationId )`                                                   |
| Collection of Notes for Reservation | `$api->getReservationNoteCollections( int $reservationId )`<br/>*Provides full paged API responses* |

---

### Reservation Rates
| Fetch                   | API Method                                          |
|-------------------------|-----------------------------------------------------|
| Rates for Reservation   | `$api->getReservationRates( int $reservationId )`   |

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
| Fetch            | API Method                                                                                               |
|------------------|----------------------------------------------------------------------------------------------------------|
| One Work Order   | `$api->getMaintenanceWorkOrder( int $maintenanceWorkOrderId )`                                           |
| Many Work Orders | `$api->getMaintenanceWorkOrders( array $queryParams )`                                                   |
| Collection       | `$api->getMaintenanceWorkOrderCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getmaintworkorders

---

### Owners
| Fetch            | API Method                                                                                |
|------------------|-------------------------------------------------------------------------------------------|
| One Owner        | `$api->getOwner( int $ownerId )`                                                          |
| Many Owners      | `$api->getOwnerOrders( array $queryParams )`                                              |
| Owner Collection | `$api->getOwnerCollections( array $queryParams )`<br/>*Provides full paged API responses* |
| Owner Units      | `$api->getOwnerUnits( int $ownerId )`<br/>*Provides array of units for the owner*         |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getownercollection

---

### Contracts
| Fetch          | API Method                                                                                   |
|----------------|----------------------------------------------------------------------------------------------|
| One Contract   | `$api->getContract( int $contractId )`                                                       |
| Many Contracts | `$api->getContracts( array $queryParams )`                                                   |
| Collection     | `$api->getContractCollections( array $queryParams )`<br/>*Provides full paged API responses* |

See available query params for `$queryParams` at https://developer.trackhs.com/reference/getownercontractcollection

---

### Manual Calls to Track API for methods not implemented
| Fetch              | API Method                                                                                    |
|--------------------|-----------------------------------------------------------------------------------------------|
| Call Once Only     | `$api->call( string $httpMethod, string $apiUrl, array $bodyParams=[] )`                      |
| Auto Follow Paging | `$api->callAndFollowPaging( string $httpMethod, string $apiUrl, array $bodyParams=[] )`       |

See available API URLs at https://developer.trackhs.com/reference/ 
Note that manual calls will not be parsed into models. The function will return the default output of `json_decode( $responseBody, false, 512, JSON_THROW_ON_ERROR )` 

