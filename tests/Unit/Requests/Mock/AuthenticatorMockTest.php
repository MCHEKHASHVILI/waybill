<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Requests\GetServerTimeRequest;
use Mchekhashvili\RsWaybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

$serverTimeAction = Action::GET_SERVER_TIME->value; // 'get_server_time'

$okXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$serverTimeAction}Response xmlns="http://tempuri.org/">
      <{$serverTimeAction}Result>2024-01-01T00:00:00</{$serverTimeAction}Result>
    </{$serverTimeAction}Response>
  </soap:Body>
</soap:Envelope>
XML;

describe('WaybillServiceConnector \u2014 authentication', function () use ($okXml) {

    test('connector can be instantiated without credentials (guest mode)', function () {
        $connector = new WaybillServiceConnector();
        expect($connector)->toBeInstanceOf(WaybillServiceConnector::class);
        expect($connector->service_username)->toBeNull();
        expect($connector->service_password)->toBeNull();
    });

    test('connector stores credentials correctly', function () {
        $connector = new WaybillServiceConnector(
            service_username: 'su_user',
            service_password: 'su_pass',
            tenant_username:  'tenant',
            tenant_password:  'secret'
        );
        expect($connector->service_username)->toBe('su_user');
        expect($connector->tenant_username)->toBe('tenant');
    });

    test('SERVICE_USER auth injects su/sp params into request body', function () use ($okXml) {
        $mockClient = new MockClient([
            GetExciseCodesRequest::class => MockResponse::make($okXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector(
            service_username: 'rsserviceuser:123',
            service_password: 'MyPass!'
        );
        $connector->withMockClient($mockClient);

        $request = new GetExciseCodesRequest([]);
        expect($request->getAuthMethod())->toBe(AuthMethod::SERVICE_USER);

        $connector->send($request);

        expect($request->getParam('su'))->toBe('rsserviceuser:123');
        expect($request->getParam('sp'))->toBe('MyPass!');
    });

    test('GUEST auth does not inject any params', function () use ($okXml) {
        $mockClient = new MockClient([
            GetServerTimeRequest::class => MockResponse::make($okXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $request = new GetServerTimeRequest([]);
        expect($request->getAuthMethod())->toBe(AuthMethod::GUEST);

        $connector->send($request);

        expect($request->getParam('su'))->toBeNull();
        expect($request->getParam('sp'))->toBeNull();
    });

});
