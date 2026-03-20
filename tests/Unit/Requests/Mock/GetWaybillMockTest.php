<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

// The SOAP action value for GetWaybillRequest
$action = Action::GET_WAYBILL->value; // 'get_waybill'

describe('GetWaybillRequest \u2014 XML body', function () use ($action) {

    test('SOAP action enum is GET_WAYBILL', function () {
        $request = new GetWaybillRequest([]);
        expect($request->getAction())->toBe(Action::GET_WAYBILL);
    });

    test('XML body contains the get_waybill action element', function () use ($action) {
        $request = new GetWaybillRequest(['id' => '12345']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain($action)   // <get_waybill ...>
            ->toContain('12345');
    });

});

describe('GetWaybillRequest \u2014 mocked response', function () use ($action) {

    test('createDtoFromResponse returns a WaybillDto on success', function () use ($action) {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$action}Response xmlns="http://tempuri.org/">
      <{$action}Result>
        <WAYBILL>
          <ID>12345</ID>
          <WAYBILL_NUMBER>WB-MOCK-001</WAYBILL_NUMBER>
          <STATUS>1</STATUS>
          <TYPE>2</TYPE>
        </WAYBILL>
      </{$action}Result>
    </{$action}Response>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            GetWaybillRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $dto = $connector->send(new GetWaybillRequest(['id' => '12345']))->dto();

        expect($dto)->toBeInstanceOf(WaybillDto::class);
        expect($dto->id)->toBe(12345);
        expect($dto->number)->toBe('WB-MOCK-001');
    });

});
