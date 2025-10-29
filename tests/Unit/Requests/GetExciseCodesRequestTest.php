<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ExciseCodeDto;
use Mchekhashvili\RsWaybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ExciseCodeDto::class, function () {
    $dto = (new WaybillServiceConnector())
        ->send(new GetExciseCodesRequest(getServiceUserCredentials()))
        ->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ExciseCodeDto::class);
});

test("Pollibility to sned filter keyword: 's_text' (string)", function () {
    $searchable = "ვისკი";
    $dto = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new GetExciseCodesRequest([
            's_text' => $searchable,
        ]))
        ->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ExciseCodeDto::class);
    expect($dto->data[0]->name)->toBeString(ExciseCodeDto::class . "failed to get the proper dto for first item in response array");
    expect($dto->data[0]->name)->toContain($searchable);
});

test("Will not break by accidentally passing wring filter keywords", function () {
    $searchable = "ვისკი";

    $dto = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new GetExciseCodesRequest([
            's_text' => $searchable,
            's_text1' => "s_text1",
            's_text2' => "s_text2",
        ]))
        ->dto();
    expect($dto)->toBeInstanceOf(ArrayDto::class);
    expect($dto)->toHaveProperty("data");
    expect($dto->data)->toContainOnlyInstancesOf(ExciseCodeDto::class);
    expect($dto->data[0]->name)->toBeString(ExciseCodeDto::class . "failed to get the proper dto for first item in response array");
    expect($dto->data[0]->name)->toContain($searchable);
});
