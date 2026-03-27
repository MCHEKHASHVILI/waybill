<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Requests\WhatIsMyIpRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("Returns " . StringDto::class . " with property (string) {value} which contains valid ip address", function () {
    $dto = (new WaybillServiceConnector())->send(new WhatIsMyIpRequest())->dto();
    expect($dto)->toBeInstanceOf(StringDto::class);
    expect($dto)->toHaveProperty("value");
    expect($dto->value)->toBeString("getting unexpected type of value for ip");
    expect(filter_var($dto->value, FILTER_VALIDATE_IP))->not->toBeFalse();
});
