<?php

use Mchekhashvili\RsWaybill\Dtos\Static\ErrorCode;
use Mchekhashvili\RsWaybill\Requests\GetErrorCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ErrorCode::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetErrorCodesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeArray();
    expect($dto)->toContainOnlyInstancesOf(ErrorCode::class);
});
