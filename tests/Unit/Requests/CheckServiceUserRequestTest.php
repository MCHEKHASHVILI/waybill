<?php

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\CheckServiceUserDto;
use Mchekhashvili\Rs\Waybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

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
