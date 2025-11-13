<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Requests\GetBarcodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Dtos\Static\BarcodeDto;

test("returned response is an array of " . BarcodeDto::class, function () {
    $response = (new WaybillServiceConnector())
        ->send(new GetBarcodesRequest([
            'bar_code' => 0,
        ]));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(BarcodeDto::class);
});
