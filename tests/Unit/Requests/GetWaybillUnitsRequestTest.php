<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillUnitDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillUnitsRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillUnitDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetWaybillUnitsRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillUnitDto::class);
});
