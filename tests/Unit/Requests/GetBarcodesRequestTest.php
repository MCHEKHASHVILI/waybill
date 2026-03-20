<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Requests\GetBarcodesRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\BarcodeDto;

test("returned response is an array of " . BarcodeDto::class, function () {
    $response = (new WaybillServiceConnector())
        ->send(new GetBarcodesRequest(array_merge(
            [
                'bar_code' => 0,
            ],
            getServiceUserCredentials()
        )));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(BarcodeDto::class);
});
