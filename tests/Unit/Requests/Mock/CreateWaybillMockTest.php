<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillCreatedDto;
use Mchekhashvili\Rs\Waybill\Requests\CreateWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

// The SOAP action value for CreateWaybillRequest
$action = Action::SAVE_WAYBILL->value; // 'save_waybill'

describe('CreateWaybillRequest \u2014 XML body', function () use ($action) {

    test('SOAP action enum is SAVE_WAYBILL', function () {
        $request = new CreateWaybillRequest([]);
        expect($request->getAction())->toBe(Action::SAVE_WAYBILL);
    });

    test('XML body contains the save_waybill action element', function () use ($action) {
        $request = new CreateWaybillRequest([
            'su' => 'testuser',
            'sp' => 'testpass',
        ]);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain($action)            // <save_waybill ...>
            ->toContain('http://tempuri.org/');
    });

    test('XML body contains passed parameters', function () {
        $request = new CreateWaybillRequest([
            'WAYBILL_NUMBER' => 'WB-0001',
            'BUYER_TIN'      => '12345678910',
        ]);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain('WB-0001')
            ->toContain('12345678910');
    });

});

describe('CreateWaybillRequest \u2014 mocked response', function () use ($action) {

    test('createDtoFromResponse returns a WaybillCreatedDto on success', function () use ($action) {
        // Mock XML uses the actual lowercase SOAP action values the RS API returns
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$action}Response xmlns="http://tempuri.org/">
      <{$action}Result>
        <RESULT>
          <ID>99999</ID>
          <WAYBILL_NUMBER>WB-TEST-001</WAYBILL_NUMBER>
          <STATUS>0</STATUS>
        </RESULT>
      </{$action}Result>
    </{$action}Response>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            CreateWaybillRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $dto = $connector->send(new CreateWaybillRequest([]))->dto();

        expect($dto)->toBeInstanceOf(WaybillCreatedDto::class);
        expect($dto->id)->toBe(99999);
        expect($dto->number)->toBe('WB-TEST-001');
    });

    test('hasRequestFailed returns true when Server Error is present', function () {
        $errorXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <soap:Fault>
      <faultcode>soap:Server</faultcode>
      <faultstring>Server Error</faultstring>
    </soap:Fault>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            CreateWaybillRequest::class => MockResponse::make($errorXml, 500, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $request  = new CreateWaybillRequest([]);
        $response = $connector->send($request);

        expect($request->hasRequestFailed($response))->toBeTrue();
    });

});
