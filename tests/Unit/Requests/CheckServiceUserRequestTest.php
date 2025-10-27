<?php

use Mchekhashvili\RsWaybill\Dtos\Static\CheckServiceUser;
use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("Check Service User request returns proper Dto", function () {
    $response = (new WaybillServiceConnector())
        ->send(new CheckServiceUserRequest(getServiceUserCredentials()))
        ->dto();
    dd($response);
    expect((new WaybillServiceConnector())
            ->send(new CheckServiceUserRequest(getServiceUserCredentials()))
            ->dto()
    )->toBeInstanceOf(CheckServiceUser::class);
    expect((new WaybillServiceConnector())
        ->send(new CheckServiceUserRequest([
            'su' => 'invalid_credentials',
            'sp' => 'invalid_credentials'
        ]))
        ->dto())->toBeInstanceOf(CheckServiceUser::class);
});
