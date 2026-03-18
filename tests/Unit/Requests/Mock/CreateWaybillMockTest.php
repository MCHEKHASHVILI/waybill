<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillCreatedDto;
use Mchekhashvili\RsWaybill\Requests\CreateWaybillRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('CreateWaybillRequest — XML body', function () {

    test('SOAP action is SaveWayBill', function () {
        $request = new CreateWaybillRequest([]);
        expect($request->getAction())->toBe(Action::SAVE_WAYBILL);
    });

    test('XML body contains the SaveWayBill action element', function () {
        $request = new CreateWaybillRequest([
            'su' => 'testuser',
            'sp' => 'testpass',
        ]);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain('SaveWayBill')
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

describe('CreateWaybillRequest — mocked response', function () {

    test('createDtoFromResponse returns a WaybillCreatedDto on success', function () {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <SaveWayBillResponse xmlns="http://tempuri.org/">
      <SaveWayBillResult>
        <RESULT>
          <ID>99999</ID>
          <WAYBILL_NUMBER>WB-TEST-001</WAYBILL_NUMBER>
        </RESULT>
      </SaveWayBillResult>
    </SaveWayBillResponse>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            CreateWaybillRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->send(new CreateWaybillRequest([]));

        expect($response->status())->toBe(200);
        expect($response->body())->toContain('WB-TEST-001');
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
