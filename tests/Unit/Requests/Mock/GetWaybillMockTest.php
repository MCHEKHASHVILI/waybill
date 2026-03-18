<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\GetWaybillRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('GetWaybillRequest — XML body', function () {

    test('SOAP action is GetWayBill', function () {
        $request = new GetWaybillRequest([]);
        expect($request->getAction())->toBe(Action::GET_WAYBILL);
    });

    test('XML body contains the GetWayBill action element', function () {
        $request = new GetWaybillRequest(['id' => '12345']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain('GetWayBill')
            ->toContain('12345');
    });

});

describe('GetWaybillRequest — mocked response', function () {

    test('returns 200 and XML body with waybill data', function () {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetWayBillResponse xmlns="http://tempuri.org/">
      <GetWayBillResult>
        <WAYBILL>
          <ID>12345</ID>
          <WAYBILL_NUMBER>WB-MOCK-001</WAYBILL_NUMBER>
          <STATUS>1</STATUS>
          <TYPE>2</TYPE>
        </WAYBILL>
      </GetWayBillResult>
    </GetWayBillResponse>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            GetWaybillRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $response = $connector->send(new GetWaybillRequest(['id' => '12345']));

        expect($response->status())->toBe(200);
        expect($response->body())->toContain('WB-MOCK-001');
    });

});
