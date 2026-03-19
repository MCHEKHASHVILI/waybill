<?php

/**
 * Integration tests for WaybillServiceConnector authentication behaviour.
 *
 * These tests require live RS credentials and make real HTTP calls.
 * All tests are guarded with ->skip(!hasCredentials(), ...) so they are
 * silently bypassed in CI and any environment without a .env file.
 */

use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('Connector with no credentials', function () {

    test('RS API returns inactive when connector and request both have no credentials', function () {
        // The authenticator still sends su/sp params but with null values,
        // which the RS API treats as invalid — returning active: false.
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest();
        $dto       = $connector->send($request)->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeFalse(
            'Null credentials unexpectedly returned an active service user'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level credentials take effect when connector has none', function () {
        // Credentials passed directly to the request are merged over the
        // connector-level null credentials, so the API call succeeds.
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest($creds);
        $dto       = $connector->send($request)->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeTrue(
            'Request credentials did not result in an active user — or test credentials were deleted from eservices.rs.ge'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});

describe('Connector with credentials', function () {

    test('connector-level credentials authenticate the service user', function () {
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector(
            service_username: $creds['su'],
            service_password: $creds['sp'],
        );
        $dto = $connector->send(new CheckServiceUserRequest())->dto();

        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeTrue(
            'Connector credentials returned inactive — service user may be deleted from eservices.rs.ge'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level invalid credentials override valid connector credentials', function () {
        // setAuthParams() merges connector auth first, then request params on top.
        // array_merge gives the latter array priority on duplicate keys,
        // so the invalid su/sp from the request overwrite the valid connector ones.
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector(
            service_username: $creds['su'],
            service_password: $creds['sp'],
        );
        $request = new CheckServiceUserRequest([
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
