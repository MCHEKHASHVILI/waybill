<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ErrorCodeDto;
use Mchekhashvili\Rs\Waybill\Requests\GetErrorCodesRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ErrorCodeDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetErrorCodesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ErrorCodeDto::class);
});
