<?php

use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an " . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillRequest(array_merge([
        'waybill_id' => '980246335'
    ], getServiceUserCredentials())));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(WaybillDto::class);
});
