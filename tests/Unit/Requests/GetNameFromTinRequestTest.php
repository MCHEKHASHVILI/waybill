<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Requests\GetNameFromTinRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("Returns " . StringDto::class . " with property (string) {value} which contains valid ip address", function () {
    $response = (new WaybillServiceConnector())->send(new GetNameFromTinRequest(array_merge(
        [
            'tin' => '206322102'
        ],
        getServiceUserCredentials()
    )));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(StringDto::class);
    expect($dto)->toHaveProperty("value");
    expect($dto->value)->toBeString("getting unexpected type of value for ip");
    expect($dto->value)->toBe("სატესტო კოდი1", "name is changed");
});
