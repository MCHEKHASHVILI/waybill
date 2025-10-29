<?php

use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillType;
use Mchekhashvili\RsWaybill\Requests\GetWaybillTypesRequest;

test("returned response is an array of " . WaybillType::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetWaybillTypesRequest(getServiceUserCredentials()))->dto();
    expect($dto)->toBeArray();
    expect($dto)->toContainOnlyInstancesOf(WaybillType::class);
});
