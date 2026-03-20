# mchekhashvili/rs-waybill

PHP SDK for the [Revenue Service of Georgia WaybillService SOAP API](https://services.rs.ge/WayBillService/WayBillService.asmx).

Part of the **Mchekhashvili RS SDK** family. The same `Mchekhashvili\Rs\` namespace is shared across all sub-packages (`rs-waybill`, `rs-invoice`, …) and the upcoming parent `rs-sdk`.

Built on [Saloon v3](https://docs.saloon.dev).

---

## Requirements

- PHP 8.1 or higher
- Composer

---

## Installation

```bash
composer require mchekhashvili/rs-waybill
```

---

## Quick start

`WaybillService` is the single entry point. Instantiate it once with your credentials and call domain-oriented methods. You never interact with Saloon directly.

```php
use Mchekhashvili\Rs\Waybill\WaybillService;

$service = new WaybillService(
    serviceUsername: 'rsserviceuser:123456789',
    servicePassword: 'YourPassword',
);

// Fetch a waybill
$waybill = $service->getWaybill(id: 976627249);

echo $waybill->number;        // "WB-0001234"
echo $waybill->status->name;  // "ACTIVE"
echo $waybill->buyer_tin;     // "12345678910"

foreach ($waybill->goods_list as $product) {
    echo "{$product->name} x{$product->quantity}\n";
}
```

---

## Authentication

The RS API uses two independent credential sets. Pass whichever pair(s) the operation requires; unused pairs can be omitted.

| Parameter | Purpose |
|---|---|
| `serviceUsername` / `servicePassword` | Service-user access — required for most waybill operations |
| `tenantUsername` / `tenantPassword` | Tenant (company account) access — required for service-user management |

```php
// Service-user credentials only (most common)
$service = new WaybillService(
    serviceUsername: 'rsserviceuser:123456789',
    servicePassword: 'YourPassword',
);

// Tenant credentials only
$service = new WaybillService(
    tenantUsername: 'mycompany',
    tenantPassword: 'secret',
);

// Both — for operations that require both (e.g. updateServiceUser)
$service = new WaybillService(
    serviceUsername: 'rsserviceuser:123456789',
    servicePassword: 'YourPassword',
    tenantUsername:  'mycompany',
    tenantPassword:  'secret',
);
```

---

## WaybillService API reference

### Waybill — reads

```php
// Fetch a single waybill by ID
WaybillDto         $service->getWaybill(int $id)

// Fetch a single waybill by its number
WaybillDto         $service->getWaybillByNumber(string $number)

// List waybills you issued (seller perspective)
WaybillDto[]       $service->getWaybills(array $params = [])
WaybillDto[]       $service->getWaybillsEx(array $params = [])
WaybillDto[]       $service->getWaybillsV1(array $params = [])

// List waybills addressed to you (buyer perspective)
WaybillDto[]       $service->getWaybillsAsBuyer(array $params = [])
WaybillDto[]       $service->getWaybillsAsBuyerEx(array $params = [])

// Fetch the goods list for a specific waybill
WaybillProductDto[] $service->getWaybillGoodsList(int $waybillId)

// Download waybill as a base64-encoded PDF string
string             $service->getWaybillAsPdf(int $waybillId)
```

### Waybill — writes

```php
// Create a new waybill from a WaybillDto
WaybillCreatedDto  $service->createWaybill(WaybillDto $waybill)

// Update a saved (draft) waybill
WaybillCreatedDto  $service->updateWaybill(WaybillDto $waybill)

// Activate a saved waybill — returns the assigned waybill number
string             $service->sendWaybill(int $waybillId)

// Confirm receipt of a waybill (buyer action)
bool               $service->confirmWaybill(int $waybillId)

// Close a waybill
bool               $service->closeWaybill(int $waybillId)

// Delete a draft waybill
bool               $service->deleteWaybill(int $waybillId)
```

#### Full create → send example

```php
use Mchekhashvili\Rs\Waybill\WaybillService;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ProductDto;
use Mchekhashvili\Rs\Waybill\Enums\DeliveryCostPayer;

$service = new WaybillService(serviceUsername: '...', servicePassword: '...');

$waybill = new WaybillDto(
    id:                   0,
    number:               '',
    sub_waybills:         null,
    goods_list:           [
        new ProductDto(
            id:           0,
            name:         'Product Name',
            unit_id:      1,
            unit_name:    null,
            quantity:     10,
            price:        5.0,
            amount:       50.0,
            bar_code:     '00001',
            vat_type:     1,
            status:       1,
            quantity_ext: null,
        ),
    ],
    type_id:              2,
    buyer_tin:            '12345678910',
    buyer_is_resident:    true,
    buyer_name:           'Company Name',
    address_from:         'Address From',
    address_to:           'Address To',
    driver_tin:           12345678910,
    driver_is_resident:   true,
    driver_name:          'Driver Name',
    delivery_cost:        100.0,
    supplier_info:        null,
    receiver_info:        null,
    delivery_date:        new DateTimeImmutable('2025-12-31T18:00:00'),
    status:               null,
    seller_tenant_id:     731937,
    parent_id:            null,
    full_amount:          50.0,
    vehicle_state_number: 'ABC123',
    service_user_id:      783,
    send_at:              new DateTimeImmutable('2025-12-30T09:00:00'),
    delivery_cost_payer:  DeliveryCostPayer::SELLER,
    delivery_type_id:     1,
    delivery_type_name:   null,
    comment:              null,
    category:             null,
);

$created = $service->createWaybill($waybill);
$number  = $service->sendWaybill($created->id);
$pdf     = $service->getWaybillAsPdf($created->id);

file_put_contents('waybill.pdf', base64_decode($pdf));
```

### Waybill templates

```php
WaybillCreatedDto  $service->createWaybillTemplate(WaybillDto $waybill)
bool               $service->deleteWaybillTemplate(int $templateId)
```

### Barcodes

```php
BarcodeDto[]  $service->getBarcodes(array $params = [])
bool          $service->createBarcode(string $barCode, string $goodsName, int $unitId)
bool          $service->deleteBarcode(string $barCode)
```

### Vehicles

```php
VehicleDto[]  $service->getVehicleStateNumbers()
bool          $service->createVehicleStateNumber(string $stateNumber)
bool          $service->deleteVehicleStateNumber(string $stateNumber)
```

### Reference data

```php
ExciseCodeDto[]         $service->getExciseCodes(string $searchText = '')
WaybillTypeDto[]        $service->getWaybillTypes()
WaybillUnitDto[]        $service->getWaybillUnits()
TransportationTypeDto[] $service->getTransportationTypes()
WoodTypeDto[]           $service->getWoodTypes()
ErrorCodeDto[]          $service->getErrorCodes()
```

### Taxpayer lookups

```php
string         $service->getNameFromTin(string $tin)
ContragentDto  $service->getTinFromUnId(int $unId)
string         $service->getPayerTypeFromUnId(int $unId)
bool           $service->isVatPayer(int $unId)
bool           $service->isVatPayerByTin(string $tin)
```

### Service user management

```php
ServiceUserDto[]  $service->getServiceUsers()
bool              $service->updateServiceUser(array $params)
```

### Utilities

```php
DateTimeImmutable  $service->getServerTime()
string             $service->getMyIp()
```

---

## Return types

All `WaybillService` methods return plain PHP objects. The internal `BooleanDto`, `StringDto`, `DateTimeDto`, and `ArrayDto` wrappers are an implementation detail of the request layer and do not appear in the facade's public API.

| Type | Description |
|---|---|
| `WaybillDto` | Full waybill with all fields and a `ProductDto[]` goods list |
| `WaybillCreatedDto` | ID and number assigned by the RS API after create or update |
| `WaybillProductDto` | A single product entry in a goods-list response |
| `BarcodeDto` | Registered barcode with name and unit |
| `VehicleDto` | Vehicle state number |
| `ExciseCodeDto` | Excise code with rate and validity period |
| `WaybillTypeDto` | Waybill type (id + name) |
| `WaybillUnitDto` | Measurement unit (id + name) |
| `TransportationTypeDto` | Transportation type (id + name) |
| `WoodTypeDto` | Wood type with optional description |
| `ErrorCodeDto` | API error code with message |
| `ContragentDto` | TIN, UN ID, and company name of a counterparty |
| `ServiceUserDto` | Service user details |

---

## Advanced: using the connector directly

`WaybillService` covers all supported endpoints. If you need direct Saloon access for custom middleware, mocking, or features not yet wrapped, the lower-level `WaybillServiceConnector` and individual request classes are available:

```php
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Requests\GetExciseCodesRequest;

$connector = new WaybillServiceConnector(
    service_username: 'rsserviceuser:123456789',
    service_password: 'YourPassword',
);

$dto = $connector->send(new GetExciseCodesRequest(['s_text' => 'whiskey']))->dto();
// $dto is ArrayDto — $dto->data is ExciseCodeDto[]
```

---

## Running tests

```bash
# Offline unit tests — no credentials needed, safe to run in CI
composer pest:unit

# Integration tests — require a .env file with live RS credentials
cp .env.example .env
composer pest:integration

# All tests
composer pest
```

Credential variables (see `.env.example`):

```
RS_SERVICE_USERNAME=rsserviceuser:123456789
RS_SERVICE_PASSWORD=YourPassword
RS_TENANT_USERNAME=mycompany
RS_TENANT_PASSWORD=secret
```

---

## Project structure

```
src/
  WaybillService.php          # Primary entry point — start here
  Connectors/                 # Saloon connector (HTTP transport layer)
  Requests/                   # One class per RS API operation (34 total)
  Dtos/
    Waybill/                  # Domain entity DTOs (WaybillDto, ProductDto, ...)
    Primitives/               # Scalar wrappers used internally (BooleanDto, StringDto, ...)
  Mappers/                    # WaybillDto <-> RS XML array conversion
  Enums/                      # WaybillStatus, DeliveryCostPayer, Action, AuthMethod, ...
  Authenticators/             # Saloon authenticator (injects su/sp/tenant params into XML)
  Interfaces/                 # HasParamsInterface, HasArrayInterface
  Traits/                     # HasParams (XML body builder), HasArray (enum helper)
  Exceptions/                 # ActionPropertyIsNotSetException
```

---

## RS SDK family

This package is one sub-package in a planned multi-service SDK for the Revenue Service of Georgia.

| Package | Namespace | Status |
|---|---|---|
| `mchekhashvili/rs-waybill` | `Mchekhashvili\Rs\Waybill\` | This package |
| `mchekhashvili/rs-invoice` | `Mchekhashvili\Rs\Invoice\` | Planned |
| `mchekhashvili/rs-sdk` | `Mchekhashvili\Rs\` | Planned — aggregates all sub-packages |

The parent SDK will expose a unified entry point:

```php
$rs = new \Mchekhashvili\Rs\RsService(serviceUsername: '...', servicePassword: '...');

$rs->waybill()->getWaybill(id: 123);
$rs->invoice()->getInvoice(id: 456);
```

---

## License

MIT
