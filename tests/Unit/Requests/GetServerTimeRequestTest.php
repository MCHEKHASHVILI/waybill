<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\DateTimeDto;
use Mchekhashvili\RsWaybill\Requests\GetServerTimeRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("Returns " . DateTimeDto::class . " with property value which is DatetimeImmutable type", function () {
    $dto = (new WaybillServiceConnector())->send(new GetServerTimeRequest())->dto();
    expect($dto)->toBeInstanceOf(DateTimeDto::class);
    expect($dto)->toHaveProperty("value");
    expect($dto->value)->toBeInstanceOf(DateTimeImmutable::class);
});
