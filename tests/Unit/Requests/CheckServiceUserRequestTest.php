<?php

use Mchekhashvili\RsWaybill\Dtos\Static\CheckServiceUserDto;
use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("Check Service User request returns proper Dto", function () {
    expect((new WaybillServiceConnector())
            ->send(new CheckServiceUserRequest(getServiceUserCredentials()))
            ->dto()
    )->toBeInstanceOf(CheckServiceUserDto::class);
    expect((new WaybillServiceConnector())
        ->send(new CheckServiceUserRequest([
            'su' => 'invalid_credentials',
            'sp' => 'invalid_credentials'
        ]))->dto())
        ->toBeInstanceOf(CheckServiceUserDto::class);
});
