<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\StringDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillAsPdfRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("Returns " . StringDto::class . " with property (string) {value} which contains valid ip address", function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillAsPdfRequest(array_merge([
        'waybill_id' => '980246335'
    ], getServiceUserCredentials())));
    $dto = $response->dto();
    $decoded = base64_decode($dto->value);
    $encoded = base64_encode($decoded);
    expect($dto)->toBeInstanceOf(StringDto::class);
    expect($dto)->toHaveProperty("value");
    expect($dto->value)->toBeString("getting unexpected type of value for ip");
    expect($dto->value)->toBe($encoded);
});
