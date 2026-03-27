<?php

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillByNumberRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillByNumberRequest(array_merge([
        'waybill_number' => '0940135439'
    ], getServiceUserCredentials())));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(WaybillDto::class);
});
