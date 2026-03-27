<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillTypeDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillTypesRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillTypeDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillTypesRequest(getServiceUserCredentials()));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillTypeDto::class);
});
