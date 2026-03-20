<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Requests\GetPayerTypeFromUnIdRequest;

test("Returns " . StringDto::class . " with property (string) {value} which contains valid ip address", function () {
    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new GetPayerTypeFromUnIdRequest([
            'un_id' => '731937'
        ]));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(StringDto::class);
    expect($dto)->toHaveProperty("value");
    expect($dto->value)->toBeString("getting unexpected type of value for ip");
    expect($dto->value)->toBe("0");
});
