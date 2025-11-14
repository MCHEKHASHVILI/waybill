<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillProductDto;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Requests\GetWaybillGoodsListRequest;

test("returned response is an array of " . WaybillProductDto::class, function () {
    $response = (new WaybillServiceConnector())->send(new GetWaybillGoodsListRequest(array_merge(
        [
            'create_date_s' => (new DateTime("now"))->sub(new \DateInterval("P2D"))->format("Y-m-d\TH:i:s")
        ],
        getServiceUserCredentials()
    )));


    // dd($response->body());
    $dto = $response->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(WaybillProductDto::class);
});
