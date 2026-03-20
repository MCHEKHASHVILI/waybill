<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\TransportationTypeDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Requests\GetTransportationTypesRequest;

test("returned response is an array of " . TransportationTypeDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetTransportationTypesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(TransportationTypeDto::class);
});
