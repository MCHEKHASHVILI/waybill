<?php

use Mchekhashvili\RsWaybill\Dtos\Convertable\ExciseCode;
use Mchekhashvili\RsWaybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . ExciseCode::class, function () {
    $response = (new WaybillServiceConnector())
        ->send(new GetExciseCodesRequest(getServiceUserCredentials()))
        ->dto();
    expect($response)->toBeArray();
    expect($response)->toContainOnlyInstancesOf(ExciseCode::class);
});

test("Can be filtered by name by setting the {search} key of " . ExciseCode::class . " and pushing it as request param", function () {
    $searchable = "ვისკი";
    $exiseCode = new ExciseCode();
    $exiseCode->search = $searchable;
    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new GetExciseCodesRequest($exiseCode))
        ->dto();
    expect($response)->toBeArray();
    expect($response)->toContainOnlyInstancesOf(ExciseCode::class);
    expect($response[0]->name)->toBeString(ExciseCode::class . "failed to get the proper response for first item in array");
    expect($response[0]->name)->toContain($searchable);
});
