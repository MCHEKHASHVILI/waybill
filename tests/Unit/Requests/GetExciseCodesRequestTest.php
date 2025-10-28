<?php

use Mchekhashvili\RsWaybill\Dtos\Static\ExciseCode;
use Mchekhashvili\RsWaybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ExciseCode::class, function () {
    $dto = (new WaybillServiceConnector())
        ->send(new GetExciseCodesRequest(getServiceUserCredentials()))
        ->dto();
    expect($dto)->toBeArray();
    expect($dto)->toContainOnlyInstancesOf(ExciseCode::class);
});

test("Pollibility to sned filter keyword: 's_text' (string)", function () {
    $searchable = "ვისკი";
    $dto = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new GetExciseCodesRequest([
            's_text' => $searchable,
        ]))
        ->dto();
    expect($dto)->toBeArray();
    expect($dto)->toContainOnlyInstancesOf(ExciseCode::class);
    expect($dto[0]->name)->toBeString(ExciseCode::class . "failed to get the proper dto for first item in response array");
    expect($dto[0]->name)->toContain($searchable);
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
    expect($dto)->toBeArray();
    expect($dto)->toContainOnlyInstancesOf(ExciseCode::class);
    expect($dto[0]->name)->toBeString(ExciseCode::class . "failed to get the proper dto for first item in response array");
    expect($dto[0]->name)->toContain($searchable);
});
