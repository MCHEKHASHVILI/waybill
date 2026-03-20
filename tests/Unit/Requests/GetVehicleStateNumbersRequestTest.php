<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\VehicleDto;
use Mchekhashvili\Rs\Waybill\Requests\GetVehicleStateNumbersRequest;

test("returned response is an array of " . VehicleDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetVehicleStateNumbersRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(VehicleDto::class);
});
