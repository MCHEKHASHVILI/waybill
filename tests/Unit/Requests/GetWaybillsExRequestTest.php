<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillsExRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillsExRequest(getServiceUserCredentials()));

    // dd($response->body());
    $dto = $response->dto();
    dd($dto);
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillDto::class);
});
