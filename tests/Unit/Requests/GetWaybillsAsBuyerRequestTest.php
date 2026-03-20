<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Requests\GetWaybillsAsBuyerRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test('returned response is an array of ' . WaybillDto::class, function () {
    $response = (new WaybillServiceConnector())
        ->send(new GetWaybillsAsBuyerRequest(getServiceUserCredentials()));

    $dto = $response->dto();

    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty('data');
    expect($dto->data)->toContainOnlyInstancesOf(WaybillDto::class);
})->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
