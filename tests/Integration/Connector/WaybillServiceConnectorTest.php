<?php

/**
 * Integration tests for WaybillServiceConnector authentication behaviour.
 *
 * NOTE: The RS API's chek_service_user endpoint returns an HTML Runtime Error
 * for all calls regardless of credentials — it cannot be used to test auth.
 * These tests use endpoints that are known to work correctly:
 *   - GetServerTimeRequest  (AuthMethod::GUEST)  — always returns valid SOAP
 *   - GetExciseCodesRequest (AuthMethod::SERVICE_USER) — works with valid creds
 *
 * All tests are guarded with ->skip(!hasCredentials(), ...) so they are
 * silently bypassed in CI and any environment without a .env file.
 */

use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\DateTimeDto;
use Mchekhashvili\RsWaybill\Requests\GetServerTimeRequest;
use Mchekhashvili\RsWaybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('Connector — GUEST endpoint (no credentials required)', function () {

    test('GetServerTimeRequest returns a DateTimeDto without any credentials', function () {
        $connector = new WaybillServiceConnector();
        $dto       = $connector->send(new GetServerTimeRequest())->dto();

        expect($dto)->toBeInstanceOf(DateTimeDto::class);
        expect($dto->value)->toBeInstanceOf(DateTimeImmutable::class);
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('GetServerTimeRequest returns a DateTimeDto even when connector has credentials', function () {
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector(
            service_username: $creds['su'],
            service_password: $creds['sp'],
        );
        $dto = $connector->send(new GetServerTimeRequest())->dto();

        expect($dto)->toBeInstanceOf(DateTimeDto::class);
        expect($dto->value)->toBeInstanceOf(DateTimeImmutable::class);
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});

describe('Connector — SERVICE_USER endpoint (credentials required)', function () {

    test('connector-level credentials allow access to a protected endpoint', function () {
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector(
            service_username: $creds['su'],
            service_password: $creds['sp'],
        );
        $dto = $connector->send(new GetExciseCodesRequest())->dto();

        expect($dto)->toBeInstanceOf(ArrayDto::class);
        expect($dto->data)->toBeArray();
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

    test('request-level credentials take effect when connector has none', function () {
        $creds     = getServiceUserCredentials();
        $connector = new WaybillServiceConnector();
        $dto       = $connector->send(new GetExciseCodesRequest($creds))->dto();

        expect($dto)->toBeInstanceOf(ArrayDto::class);
        expect($dto->data)->toBeArray();
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

});
