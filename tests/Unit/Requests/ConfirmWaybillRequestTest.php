<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\ConfirmWaybillRequest;

test("return boolean", function () {
    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new ConfirmWaybillRequest([
            "waybill_id" => "979186275"
        ]));
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto)->toHaveProperty("result");
    expect($dto->result)->toBeBool();
    expect($dto->result)->toBeTrue("could not confirm");
});
