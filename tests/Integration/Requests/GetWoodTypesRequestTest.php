<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WoodTypeDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWoodTypesRequest;

test("returned response is an array of " . WoodTypeDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetWoodTypesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WoodTypeDto::class);
});
