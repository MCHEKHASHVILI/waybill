<?php

use Mchekhashvili\RsWaybill\Dtos\Static\ErrorCode;
use Mchekhashvili\RsWaybill\Requests\GetErrorCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ErrorCode::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetErrorCodesRequest(getServiceUserCredentials()))->dto();
    expect($response)->toBeArray();
    expect($response)->toContainOnlyInstancesOf(ErrorCode::class);
});
