<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillTypeDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillTypesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillTypeDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillTypesRequest(getServiceUserCredentials()));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillTypeDto::class);
});
