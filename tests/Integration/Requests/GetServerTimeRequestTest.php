<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\DateTimeDto;
use Mchekhashvili\Rs\Waybill\Requests\GetServerTimeRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("Returns " . DateTimeDto::class . " with property value which is DatetimeImmutable type", function () {
    $dto = (new WaybillServiceConnector())->send(new GetServerTimeRequest())->dto();
    expect($dto)->toBeInstanceOf(DateTimeDto::class);
    expect($dto)->toHaveProperty("value");
    expect($dto->value)->toBeInstanceOf(DateTimeImmutable::class);
});
