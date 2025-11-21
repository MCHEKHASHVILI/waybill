<?php

use Mchekhashvili\RsWaybill\Requests\GetCWaybillRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("This request does not work on rs side, returns request timeout", function () {
    // $response = (new WaybillServiceConnector())->send(new GetCWaybillRequest(array_merge([
    //     's_dt' => getYesterday(),
    //     'e_dt' => getToday()
    // ], getServiceUserCredentials())));
    // dd($response->getPendingRequest()->body());
});
