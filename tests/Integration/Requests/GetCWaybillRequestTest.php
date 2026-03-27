<?php

use Mchekhashvili\Rs\Waybill\Requests\GetCWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

test("This request does not work on rs side, returns request timeout", function () {
    // $response = (new WaybillServiceConnector())->send(new GetCWaybillRequest(array_merge([
    //     's_dt' => getYesterday(),
    //     'e_dt' => getToday()
    // ], getServiceUserCredentials())));
    // dd($response->getPendingRequest()->body());
})->skip("This request does not have any explanation in the documentation, and it does not work on rs side, returns request timeout");
