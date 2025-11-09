<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\TransportationTypeDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\GetTransportationTypesRequest;

test("returned response is an array of " . TransportationTypeDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetTransportationTypesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(TransportationTypeDto::class);
});
