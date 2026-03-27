<?php

use Mchekhashvili\Rs\Waybill\Requests\GetTinFromUnIdRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ContragentDto;

test("Returns " . ContragentDto::class . " with property (string) {value} which contains valid ip address", function () {
    $response = (new WaybillServiceConnector())->send(new GetTinFromUnIdRequest(array_merge([
        'un_id' => '731937'
    ], getServiceUserCredentials())));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ContragentDto::class);
});
