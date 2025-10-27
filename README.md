### Handler of Api: https://services.rs.ge/WayBillService/WayBillService.asmx

## Usage
### First you declare the constructor. It accepts credentials. passing the credentials is optional but recomended. 
```php
<?php

use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

$connector = new WaybillServiceConnector(
        protected string|null service_username,
        protected string|null service_password,
        protected string|null tenant_username,
        protected string|null tenant_password
);
```
### Then you define specified Request object
```php
<?php

use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;

$request = new CheckServiceUserRequest(mixed $params);
```
If you did not specify the credentials in constructor it is mandatory to send it as an array in request object, otherwise you can not access to api data.

### Then you can send the request and get the Dto from response
```php
<?php

use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

$connector = new WaybillServiceConnector();

$request = new CheckServiceUserRequest();

$response = $connector->send($request);

dd($response->dto());

// The above code will dump CheckServiceUserDto
^ Mchekhashvili\RsWaybill\Dtos\Static\CheckServiceUser^ {#453
  +registered: false
  +tenant_id: -3
  +user_id: -3
}
```
