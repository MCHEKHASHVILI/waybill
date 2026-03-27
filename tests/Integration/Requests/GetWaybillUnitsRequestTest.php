<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillUnitDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillUnitsRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillUnitDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetWaybillUnitsRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillUnitDto::class);
});
