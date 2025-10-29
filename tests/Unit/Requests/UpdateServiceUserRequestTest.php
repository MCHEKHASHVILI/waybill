<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Requests\UpdateServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("Returns boolean, can update password, note, and ip address, keywords: sp", function () {
    $connector = new WaybillServiceConnector(
        ...array_values(getServiceUserCredentials()),
        ...array_values(getTenantCredentials())
    );
    $response = $connector->send(new UpdateServiceUserRequest(["sp" => "dumbPassword"]))->dto();
    expect($response)->toBeInstanceOf(BooleanDto::class);
    expect($response)->toHaveProperty("result");
    expect($response->result)->toBeBool();
    expect($response->result)->toBeTrue("could not update");
    // make sure update happened
    $checkingServiceUser = $connector->send(new CheckServiceUserRequest(["sp" => "dumbPassword"]))->dto();
    expect($checkingServiceUser->active)->toBeBool("response must be a boolean");
    expect($checkingServiceUser->active)->toBeTrue("could not update");
    // reverse password and check again
    $response = $connector->send(new UpdateServiceUserRequest())->dto();
    $checkingServiceUser = $connector->send(new CheckServiceUserRequest())->dto();
    expect($checkingServiceUser->active)->toBeBool("response must be a boolean");
    expect($checkingServiceUser->active)->toBeTrue("could not update");
});
