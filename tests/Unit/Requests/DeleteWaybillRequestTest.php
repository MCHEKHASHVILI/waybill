<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Requests\DeleteWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("returned response is a " . BooleanDto::class, function () {
    $data = [
        "waybill_id" => "978941484"
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new DeleteWaybillRequest($data));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto->result)->toBeFalse("accidentally deleted waybill");
});
