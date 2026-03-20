<?php

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillRequest(array_merge([
        'waybill_id' => '980246335'
    ], getServiceUserCredentials())));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(WaybillDto::class);
});
