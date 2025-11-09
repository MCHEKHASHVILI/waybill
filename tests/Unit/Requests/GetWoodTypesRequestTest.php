<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Dtos\Static\WoodTypeDto;
use Mchekhashvili\RsWaybill\Requests\GetWoodTypesRequest;

test("returned response is an array of " . WoodTypeDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetWoodTypesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WoodTypeDto::class);
});
