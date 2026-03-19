<?php

/**
 * Integration tests for WaybillServiceConnector authentication behaviour.
 *
 * These tests require live RS credentials and make real HTTP calls.
 * All tests are guarded with ->skip(!hasCredentials(), ...) so they are
 * silently bypassed in CI and any environment without a .env file.
 *
 * Important: The RS API does NOT return a proper SOAP fault for invalid/missing
 * credentials. It returns an HTML error page instead. CheckServiceUserRequest
 * handles this gracefully in hasRequestFailed() and createDtoFromResponse(),
 * returning active: false safely without crashing the XML parser.
 */

use Mchekhashvili\RsWaybill\Requests\CheckServiceUserRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\RsWaybill\Dtos\Static\CheckServiceUserDto;

describe('Connector with no credentials', function () {

    test('returns inactive DTO when connector and request both have no credentials', function () {
        // RS server returns an HTML error page for null credentials.
        // CheckServiceUserRequest catches this and returns active: false safely.
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest();
        $dto       = $connector->send($request)->dto();

        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
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

        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
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

        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeTrue(
            'Connector credentials returned inactive — service user may be deleted from eservices.rs.ge'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level invalid credentials override valid connector credentials', function () {
        // setAuthParams() merges connector auth first, then request params on top.
        // array_merge gives the latter array priority on duplicate keys,
        // so the invalid su/sp from the request overwrite the valid connector ones.
        // The RS server returns an HTML error page for invalid credentials,
        // which CheckServiceUserRequest handles gracefully as active: false.
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

        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
        expect($dto)->toHaveProperty('active');
        expect($dto->active)->toBeFalse(
            'Request-level invalid credentials did not override valid connector credentials'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});
