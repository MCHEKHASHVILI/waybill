<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Requests\DeleteVehicleStateNumberRequest;

test("returned response is a " . BooleanDto::class, function () {
    $data =  [
        "car_number" => "returns true without validation"
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new DeleteVehicleStateNumberRequest($data));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto->result)->toBeTrue("could not delete car number");
});
