<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\DeleteVehicleStateNumberRequest;

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
