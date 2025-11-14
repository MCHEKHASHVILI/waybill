<?php

use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillByNumberRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillByNumberRequest(array_merge([
        'waybill_number' => '0940135439'
    ], getServiceUserCredentials())));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(WaybillDto::class);
});
