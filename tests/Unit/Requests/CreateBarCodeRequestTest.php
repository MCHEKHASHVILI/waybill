<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Requests\CreateBarcodeRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test('returned response is a ' . BooleanDto::class, function () {
    $data = [
        'bar_code'   => 'some code',
        'goods_name' => 'some name',
        'unit_id'    => '1',
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new CreateBarcodeRequest($data));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto->result)->toBeTrue('could not create a barcode');
})->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
