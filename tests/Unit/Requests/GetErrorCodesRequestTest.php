<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ErrorCodeDto;
use Mchekhashvili\RsWaybill\Requests\GetErrorCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ErrorCodeDto::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetErrorCodesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ErrorCodeDto::class);
});
