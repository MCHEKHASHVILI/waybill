<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Requests\ConfirmWaybillRequest;

test('returns a ' . BooleanDto::class, function () {
    $creds = getServiceUserCredentials();
    $response = (new WaybillServiceConnector(
        service_username: $creds['su'],
        service_password: $creds['sp'],
    ))->send(new ConfirmWaybillRequest([
        'waybill_id' => '979186275',
    ]));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto)->toHaveProperty('result');
    expect($dto->result)->toBeBool();
})->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
