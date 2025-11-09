<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Dtos\Static\VehicleDto;
use Mchekhashvili\RsWaybill\Requests\GetVehicleStateNumbersRequest;

test("returned response is an array of " . VehicleDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetVehicleStateNumbersRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(VehicleDto::class);
});
