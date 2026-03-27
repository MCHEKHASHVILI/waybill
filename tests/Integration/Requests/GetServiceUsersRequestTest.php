<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ServiceUserDto;
use Mchekhashvili\Rs\Waybill\Requests\GetServiceUsersRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ServiceUserDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetServiceUsersRequest(getTenantCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ServiceUserDto::class);
});
