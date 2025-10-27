<?php

use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe("Connector with no credentials", function () {
    test("Does not authenticate service user", function () {
        $connector = new WaybillServiceConnector();
        $request = new CheckServiceUserRequest();
        $response = $connector->send($request)->dto();
        expect($response->registered)->toBeFalse("Empty credentials returned true value of service user");
    });
    test("Can pass authentication if request receives proper service_user credentials", function () {
        $connector = new WaybillServiceConnector();
        $request = new CheckServiceUserRequest(getServiceUserCredentials());
        $response = $connector->send($request)->dto();
        expect($response->registered)->toBeTrue("Request does not ovverride auth params or test user declared in PestPHP is deleted from eservices.rs.ge database");
    });
});

describe("Connector with credentials", function () {
    test("Authenticates service user", function () {
        $connector = new WaybillServiceConnector(...array_values(getServiceUserCredentials()));
        $request = new CheckServiceUserRequest();
        $response = $connector->send($request)->dto();
        expect($response->registered)->toBeTrue("Test credentials returned false value, service user may be deleted from eservices.rs.ge. database");
    });
    test("Can pass authentication if request receives proper service_user credentials", function () {
        $connector = new WaybillServiceConnector(...array_values(getServiceUserCredentials()));
        $request = new CheckServiceUserRequest([
            'su' => 'invalid_credentials',
            'sp' => 'invalid_credentials'
        ]);
        $response = $connector->send($request)->dto();
        expect($response->registered)->toBeFalse("Request does not ovverride auth params");
    });
});
