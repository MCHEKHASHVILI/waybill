<?php

use Mchekhashvili\RsWaybill\Requests\GetTinFromUnIdRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Dtos\Static\ContragentDto;

test("Returns " . ContragentDto::class . " with property (string) {value} which contains valid ip address", function () {
    $response = (new WaybillServiceConnector())->send(new GetTinFromUnIdRequest(array_merge([
        'un_id' => '731937'
    ], getServiceUserCredentials())));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ContragentDto::class);
});
