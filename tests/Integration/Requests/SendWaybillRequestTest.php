<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Requests\SendWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

/**
 * SendWaybillRequest returns a StringDto containing the waybill number
 * assigned by the RS API on successful activation.
 */
test('returned response is a ' . StringDto::class, function () {
    $data = [
        'waybill_id' => '978941484',
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new SendWaybillRequest($data));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(StringDto::class);
    expect($dto)->toHaveProperty('value');
    expect($dto->value)->toBeString();
})->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
