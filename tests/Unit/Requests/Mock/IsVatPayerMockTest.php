<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Requests\IsVatPayerRequest;
use Mchekhashvili\RsWaybill\Requests\IsVatPayerTinRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

describe('IsVatPayerRequest — XML body', function () {

    test('SOAP action is correct', function () {
        $request = new IsVatPayerRequest(['un_id' => '731937']);
        expect($request->getAction())->toBe(Action::IS_VAT_PAYER);
    });

    test('XML body contains un_id param', function () {
        $request = new IsVatPayerRequest(['un_id' => '731937']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)->toContain('731937');
    });

});

describe('IsVatPayerRequest — mocked response: true', function () {

    test('dto result is true when service returns true', function () {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <IsVatPayerResponse xmlns="http://tempuri.org/">
      <IsVatPayerResult>true</IsVatPayerResult>
    </IsVatPayerResponse>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            IsVatPayerRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $dto = $connector->send(new IsVatPayerRequest(['un_id' => '731937']))->dto();

        expect($dto)->toBeInstanceOf(BooleanDto::class);
        expect($dto->result)->toBeTrue();
    });

});

describe('IsVatPayerRequest — mocked response: false', function () {

    test('dto result is false when service returns false', function () {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <IsVatPayerResponse xmlns="http://tempuri.org/">
      <IsVatPayerResult>false</IsVatPayerResult>
    </IsVatPayerResponse>
  </soap:Body>
</soap:Envelope>
XML;

        $mockClient = new MockClient([
            IsVatPayerRequest::class => MockResponse::make($mockXml, 200, ['Content-Type' => 'text/xml']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $dto = $connector->send(new IsVatPayerRequest(['un_id' => '000000']))->dto();

        expect($dto)->toBeInstanceOf(BooleanDto::class);
        expect($dto->result)->toBeFalse();
    });

});

describe('IsVatPayerTinRequest — XML body', function () {

    test('XML body contains tin param', function () {
        $request = new IsVatPayerTinRequest(['tin' => '12345678910']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)->toContain('12345678910');
    });

});
