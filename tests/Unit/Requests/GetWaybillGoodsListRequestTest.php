<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillProductDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\GetWaybillGoodsListRequest;

test("returned response is an array of " . WaybillProductDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillGoodsListRequest(array_merge(
        [
            'create_date_s' => '2025-11-01'
        ],
        getServiceUserCredentials()
    )));

    // dd($response->body());
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillProductDto::class);
});
