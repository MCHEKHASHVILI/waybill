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
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest();
        $dto       = $connector->send($request)->dto();

        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
        expect($dto->active)->toBeFalse(
            'Null credentials unexpectedly returned an active service user'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level credentials take effect when connector has none', function () {
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector();
        $request   = new CheckServiceUserRequest($creds);
        $response  = $connector->send($request);
        $dto       = $response->dto();

        // Dump raw response on failure so we can see what the RS API actually returned
        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
        expect($dto->active)->toBeTrue(
            sprintf(
                "active=false. Raw response body: %s",
                substr($response->body(), 0, 500)
            )
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
        $response = $connector->send(new CheckServiceUserRequest());
        $dto      = $response->dto();

        // Dump raw response on failure so we can see what the RS API actually returned
        expect($dto)->toBeInstanceOf(CheckServiceUserDto::class);
        expect($dto->active)->toBeTrue(
            sprintf(
                "active=false. Raw response body: %s",
                substr($response->body(), 0, 500)
            )
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level invalid credentials override valid connector credentials', function () {
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
        expect($dto->active)->toBeFalse(
            'Request-level invalid credentials did not override valid connector credentials'
        );
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});
