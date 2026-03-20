<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Primitives\ArrayDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ExciseCodeDto;
use Mchekhashvili\Rs\Waybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

// The SOAP action value for GetExciseCodesRequest
$action = Action::GET_EXCISE_CODES->value; // 'get_akciz_codes'

describe('GetExciseCodesRequest \u2014 XML body', function () use ($action) {

    test('SOAP action enum is GET_EXCISE_CODES', function () {
        $request = new GetExciseCodesRequest([]);
        expect($request->getAction())->toBe(Action::GET_EXCISE_CODES);
    });

    test('XML body contains the get_akciz_codes action element', function () use ($action) {
        $request = new GetExciseCodesRequest(['s_text' => 'ვისკი']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain($action)      // <get_akciz_codes ...>
            ->toContain('ვისკი');
    });

    test('XML body is valid even without parameters', function () use ($action) {
        $request = new GetExciseCodesRequest([]);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toBeString()
            ->toContain('soap:Envelope')
            ->toContain($action);
    });

});

describe('GetExciseCodesRequest \u2014 mocked response', function () use ($action) {

    test('dto is an ArrayDto containing ExciseCodeDto instances', function () use ($action) {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$action}Response xmlns="http://tempuri.org/">
      <{$action}Result>
        <AKCIZ_CODES>
          <AKCIZ_CODE>
            <ID>1</ID>
            <TITLE>ვისკი</TITLE>
            <SAKON_KODI>123</SAKON_KODI>
            <AKCIS_GANAKV>10.5</AKCIS_GANAKV>
          </AKCIZ_CODE>
          <AKCIZ_CODE>
            <ID>2</ID>
            <TITLE>ლუდი</TITLE>
            <SAKON_KODI>456</SAKON_KODI>
            <AKCIS_GANAKV>5.0</AKCIS_GANAKV>
          </AKCIZ_CODE>
        </AKCIZ_CODES>
      </{$action}Result>
    </{$action}Response>
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
        expect($dto->data)->toHaveCount(2);
        expect($dto->data[0])->toBeInstanceOf(ExciseCodeDto::class);
        expect($dto->data[0]->name)->toBe('ვისკი');
        expect($dto->data[1]->name)->toBe('ლუდი');
    });

});
