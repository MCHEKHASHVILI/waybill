<?php

use Mchekhashvili\RsWaybill\Dtos\Static\ServiceUser;
use Mchekhashvili\RsWaybill\Requests\GetServiceUsersRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ServiceUser::class, function () {
    $dto = (new WaybillServiceConnector())->send(new GetServiceUsersRequest(getTenantCredentials()))->dto();
    expect($dto)->toBeArray();
    expect($dto)->toContainOnlyInstancesOf(ServiceUser::class);
});
