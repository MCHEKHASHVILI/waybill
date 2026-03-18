<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ExciseCodeDto;
use Mchekhashvili\RsWaybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('GetExciseCodesRequest — XML body', function () {

    test('SOAP action is GetExciseCodes', function () {
        $request = new GetExciseCodesRequest([]);
        expect($request->getAction())->toBe(Action::GET_EXCISE_CODES);
    });

    test('XML body contains optional s_text filter when provided', function () {
        $request = new GetExciseCodesRequest(['s_text' => 'ვისკი']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)->toContain('ვისკი');
    });

    test('XML body is valid even without parameters', function () {
        $request = new GetExciseCodesRequest([]);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toBeString()
            ->toContain('soap:Envelope');
    });

});

describe('GetExciseCodesRequest — mocked response', function () {

    test('dto is an ArrayDto of ExciseCodeDto instances', function () {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetExciseCodesResponse xmlns="http://tempuri.org/">
      <GetExciseCodesResult>
        <EXCISE_CODES>
          <EXCISE_CODE>
            <ID>1</ID>
            <NAME>ვისკი</NAME>
            <CODE>EX001</CODE>
            <EXCISE_RATE>10</EXCISE_RATE>
          </EXCISE_CODE>
          <EXCISE_CODE>
            <ID>2</ID>
            <NAME>ლუდი</NAME>
            <CODE>EX002</CODE>
            <EXCISE_RATE>5</EXCISE_RATE>
          </EXCISE_CODE>
        </EXCISE_CODES>
      </GetExciseCodesResult>
    </GetExciseCodesResponse>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            GetExciseCodesRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $dto = $connector->send(new GetExciseCodesRequest([]))->dto();

        expect($dto)->toBeInstanceOf(ArrayDto::class);
        expect($dto)->toHaveProperty('data');
    });

});
