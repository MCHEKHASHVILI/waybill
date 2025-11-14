<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillsAsBuyerRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillsAsBuyerRequest(getServiceUserCredentials()));

    // dd($response->body());
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillDto::class);
});
