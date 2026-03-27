<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsAsBuyerRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test('returned response is an array of ' . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new GetWaybillsAsBuyerRequest(getServiceUserCredentials()));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty('data');
    expect($dto->data)->toContainOnlyInstancesOf(WaybillDto::class);
})->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
