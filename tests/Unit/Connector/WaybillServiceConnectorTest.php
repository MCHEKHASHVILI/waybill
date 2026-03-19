<?php

use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('Connector with no credentials', function () {

    test('does not authenticate service user when no credentials are given', function () {
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest();
        $dto       = $connector->send($request)->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeFalse(
            'Empty credentials unexpectedly returned an active service user'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level credentials override missing connector credentials', function () {
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest(getServiceUserCredentials());
        $dto       = $connector->send($request)->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeTrue(
            'Request credentials did not override connector — or test user was deleted from eservices.rs.ge'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});

describe('Connector with credentials', function () {

    test('authenticates service user when connector is given credentials', function () {
        $connector = new WaybillServiceConnector(...array_values(getServiceUserCredentials()));
        $request   = new CheckServiceUserRequest();
        $dto       = $connector->send($request)->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeTrue(
            'Connector credentials returned inactive — service user may be deleted from eservices.rs.ge'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('invalid request credentials override valid connector credentials', function () {
        $connector = new WaybillServiceConnector(...array_values(getServiceUserCredentials()));
        $request   = new CheckServiceUserRequest([
            'su' => 'invalid_user',
            'sp' => 'invalid_password',
        ]);
        $dto = $connector->send($request)->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeFalse(
            'Request-level invalid credentials did not override valid connector credentials'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});
