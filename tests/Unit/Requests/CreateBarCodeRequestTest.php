<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillTypeDto;
use Mchekhashvili\RsWaybill\Requests\CreateBarCodeRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillTypeDto::class, function () {
    $data =  [
        "bar_code" => "some code",
        "goods_name" => "some name",
        "unit_id" => "1",
        // "unit_txt" => "2",
        // "a_id" => "2",
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new CreateBarCodeRequest($data));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto->result)->toBeTrue("could not create a barcode");
});
