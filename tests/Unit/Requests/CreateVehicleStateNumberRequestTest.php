<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Requests\CreateVehicleStateNumberRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is a " . BooleanDto::class, function () {
    $data =  [
        "car_number" => "BB111BB",
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new CreateVehicleStateNumberRequest($data));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto->result)->not()->toBeTrue("could not create a barcode");
});
