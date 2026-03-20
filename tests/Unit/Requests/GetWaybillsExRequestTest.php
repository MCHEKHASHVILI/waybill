<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsExRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillsExRequest(getServiceUserCredentials()));

    // dd($response->body());
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillDto::class);
});
