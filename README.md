# RS Waybill SDK

PHP SDK for the [Revenue Service of Georgia WaybillService SOAP API](https://services.rs.ge/WayBillService/WayBillService.asmx).

Built on [Saloon v3](https://docs.saloon.dev).

---

## Installation

```bash
composer require mchekhashvili/rs-waybill
```

---

## Authentication

The RS API uses two independent credential sets:

| Credential | Purpose |
|---|---|
| `service_username` / `service_password` | Service-user access (most operations) |
| `tenant_username` / `tenant_password` | Tenant (company account) access |

Pass whichever pair(s) the operation requires to the connector constructor. Unused pairs can be omitted.

---

## Quick start

```php
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\GetWaybillRequest;
use Mchekhashvili\RsWaybill\Requests\CreateWaybillRequest;
use Mchekhashvili\RsWaybill\Requests\SendWaybillRequest;
use Mchekhashvili\RsWaybill\Requests\GetWaybillAsPdfRequest;

// 1. Create the connector with your credentials
$connector = new WaybillServiceConnector(
    service_username: 'rsserviceuser:123456789',
    service_password: 'YourPassword',
    tenant_username:  'tbilisi',
    tenant_password:  'secret',
);

// 2. Fetch a single waybill by ID
$response = $connector->send(new GetWaybillRequest(['id' => 12345]));
/** @var \Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto $waybill */
$waybill = $response->dto();

echo $waybill->number;        // e.g. "WB-0001234"
echo $waybill->status->name;  // e.g. "ACTIVE"
echo $waybill->buyer_tin;     // e.g. "12345678910"

foreach ($waybill->goods_list as $product) {
    echo $product->name . ' x' . $product->quantity;
}

// 3. Create a waybill
$response = $connector->send(new CreateWaybillRequest([
    'TYPE'          => 2,
    'BUYER_TIN'     => '12345678910',
    'BUYER_NAME'    => 'შპს მაგალითი',
    'START_ADDRESS' => 'თბილისი, რუსთაველის გამზირი 1',
    'END_ADDRESS'   => 'თბილისი, ვაჟა-ფშაველას გამზ. 45',
    'CAR_NUMBER'    => 'ABC123',
    'S_USER_ID'     => 783,
    'GOODS_LIST'    => [
        [
            'W_NAME'   => 'პროდუქტი',
            'UNIT_ID'  => 1,
            'QUANTITY' => 10,
            'PRICE'    => 5,
            'AMOUNT'   => 50,
            'BAR_CODE' => '00001',
            'VAT_TYPE' => 1,
        ],
    ],
]));
/** @var \Mchekhashvili\RsWaybill\Dtos\Static\WaybillCreatedDto $created */
$created = $response->dto();
echo $created->id;      // assigned waybill ID
echo $created->number;  // assigned waybill number

// 4. Send (activate) the waybill
$response = $connector->send(new SendWaybillRequest(['id' => $created->id]));
/** @var \Mchekhashvili\RsWaybill\Dtos\InBuilt\StringDto $sent */
$sent = $response->dto();
echo $sent->value; // waybill number confirmed by RS

// 5. Download as PDF
$response  = $connector->send(new GetWaybillAsPdfRequest(['id' => $created->id]));
$base64pdf = $response->dto()->value;
file_put_contents('waybill.pdf', base64_decode($base64pdf));
```

---

## Available requests

### Waybill operations
| Class | Description |
|---|---|
| `CreateWaybillRequest` | Create a new waybill |
| `UpdateWaybillRequest` | Update a saved waybill |
| `SendWaybillRequest` | Activate / send a waybill |
| `ConfirmWaybillRequest` | Confirm receipt |
| `CloseWaybillRequest` | Close a waybill |
| `DeleteWaybillRequest` | Delete a draft waybill |
| `GetWaybillRequest` | Fetch by ID |
| `GetWaybillByNumberRequest` | Fetch by number |
| `GetWaybillsRequest` | List waybills (seller) |
| `GetWaybillsExRequest` | List waybills extended (seller) |
| `GetWaybillsV1Request` | List waybills v1 (seller) |
| `GetWaybillsAsBuyerRequest` | List waybills (buyer) |
| `GetWaybillsAsBuyerExRequest` | List waybills extended (buyer) |
| `GetCWaybillRequest` | Fetch corrective waybill |
| `GetWaybillAsPdfRequest` | Fetch as base64-encoded PDF |
| `GetWaybillGoodsListRequest` | Fetch goods list |

### Template operations
| Class | Description |
|---|---|
| `CreateWaybillTemplateRequest` | Save a waybill template |
| `DeleteWaybillTemplateRequest` | Delete a waybill template |

### Reference data
| Class | Description |
|---|---|
| `GetWaybillTypesRequest` | List waybill types |
| `GetWaybillUnitsRequest` | List measurement units |
| `GetTransportationTypesRequest` | List transportation types |
| `GetWoodTypesRequest` | List wood types |
| `GetExciseCodesRequest` | List excise codes (filterable by `s_text`) |
| `GetErrorCodesRequest` | List API error codes |
| `GetServerTimeRequest` | RS server time |

### Taxpayer lookups
| Class | Description |
|---|---|
| `IsVatPayerRequest` | VAT status by UN ID |
| `IsVatPayerTinRequest` | VAT status by TIN |
| `GetNameFromTinRequest` | Company name by TIN |
| `GetTinFromUnIdRequest` | TIN + name by UN ID |
| `GetPayerTypeFromUnIdRequest` | Payer type by UN ID |

### Barcodes & vehicles
| Class | Description |
|---|---|
| `CreateBarcodeRequest` | Register a barcode |
| `DeleteBarcodeRequest` | Delete a barcode |
| `GetBarcodesRequest` | List barcodes |
| `CreateVehicleStateNumberRequest` | Register a vehicle number |
| `DeleteVehicleStateNumberRequest` | Delete a vehicle number |
| `GetVehicleStateNumbersRequest` | List vehicle numbers |

### Service user management
| Class | Description |
|---|---|
| `CheckServiceUserRequest` | Verify service user credentials |
| `UpdateServiceUserRequest` | Update service user |
| `GetServiceUsersRequest` | List service users for a tenant |

### Utilities
| Class | Description |
|---|---|
| `WhatIsMyIpRequest` | Caller's public IP as seen by RS |

---

## Response DTOs

| DTO | Returned by |
|---|---|
| `WaybillDto` | `GetWaybillRequest`, `GetWaybillByNumberRequest`, `GetCWaybillRequest` |
| `WaybillCreatedDto` | `CreateWaybillRequest`, `UpdateWaybillRequest`, `CreateWaybillTemplateRequest` |
| `ArrayDto` of `WaybillDto` | `GetWaybillsRequest`, `GetWaybillsExRequest`, `GetWaybillsV1Request`, `GetWaybillsAsBuyerRequest`, `GetWaybillsAsBuyerExRequest` |
| `ArrayDto` of `WaybillProductDto` | `GetWaybillGoodsListRequest` |
| `ArrayDto` of `ExciseCodeDto` | `GetExciseCodesRequest` |
| `ArrayDto` of `BarcodeDto` | `GetBarcodesRequest` |
| `ArrayDto` of `ServiceUserDto` | `GetServiceUsersRequest` |
| `ArrayDto` of `TransportationTypeDto` | `GetTransportationTypesRequest` |
| `ArrayDto` of `WaybillTypeDto` | `GetWaybillTypesRequest` |
| `ArrayDto` of `WaybillUnitDto` | `GetWaybillUnitsRequest` |
| `ArrayDto` of `WoodTypeDto` | `GetWoodTypesRequest` |
| `ArrayDto` of `VehicleDto` | `GetVehicleStateNumbersRequest` |
| `ContragentDto` | `GetTinFromUnIdRequest` |
| `CheckServiceUserDto` | `CheckServiceUserRequest` |
| `BooleanDto` | `IsVatPayerRequest`, `IsVatPayerTinRequest`, `ConfirmWaybillRequest`, `CloseWaybillRequest`, `DeleteWaybillRequest`, `DeleteWaybillTemplateRequest`, `CreateBarcodeRequest`, `DeleteBarcodeRequest`, `CreateVehicleStateNumberRequest`, `DeleteVehicleStateNumberRequest`, `UpdateServiceUserRequest` |
| `StringDto` | `SendWaybillRequest`, `GetWaybillAsPdfRequest`, `GetNameFromTinRequest`, `GetPayerTypeFromUnIdRequest`, `WhatIsMyIpRequest` |
| `DateTimeDto` | `GetServerTimeRequest` |

---

## Running tests

```bash
# Offline mock tests — no credentials needed
composer pest:unit

# Integration tests — require .env with RS credentials
cp .env.example .env   # fill in your credentials
composer pest:integration

# All tests
composer pest
```
