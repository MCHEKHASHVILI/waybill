<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Requests\DeleteWaybillTemplateRequest;

test("returned response is a " . BooleanDto::class, function () {
    $data = [
        "id" => "979178200"
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new DeleteWaybillTemplateRequest($data));

    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(BooleanDto::class);
    expect($dto->result)->toBeTrue("could not delete waybill template");
});
