<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\DeleteWaybillTemplateRequest;

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
