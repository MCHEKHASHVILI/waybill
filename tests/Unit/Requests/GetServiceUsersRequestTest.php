<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ServiceUserDto;
use Mchekhashvili\RsWaybill\Requests\GetServiceUsersRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ServiceUserDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetServiceUsersRequest(getTenantCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ServiceUserDto::class);
});
