<?php

use Mchekhashvili\RsWaybill\Dtos\Static\ServiceUser;
use Mchekhashvili\RsWaybill\Requests\GetServiceUsersRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ServiceUser::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetServiceUsersRequest(getTenantCredentials()))->dto();
    expect($response)->toBeArray();
    expect($response)->toContainOnlyInstancesOf(ServiceUser::class);
});
