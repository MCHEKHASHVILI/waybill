<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Requests\IsVatPayerRequest;
use Mchekhashvili\RsWaybill\Requests\IsVatPayerTinRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

// The SOAP action values from the Action enum
$isVatPayerAction    = Action::IS_VAT_PAYER->value;     // 'is_vat_payer'
$isVatPayerTinAction = Action::IS_VAT_PAYER_TIN->value; // 'is_vat_payer_tin'

describe('IsVatPayerRequest \u2014 XML body', function () use ($isVatPayerAction) {

    test('SOAP action enum is IS_VAT_PAYER', function () {
        $request = new IsVatPayerRequest(['un_id' => '731937']);
        expect($request->getAction())->toBe(Action::IS_VAT_PAYER);
    });

    test('XML body contains un_id param', function () use ($isVatPayerAction) {
        $request = new IsVatPayerRequest(['un_id' => '731937']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain($isVatPayerAction) // <is_vat_payer ...>
            ->toContain('731937');
    });

});

describe('IsVatPayerRequest \u2014 mocked response: true', function () use ($isVatPayerAction) {

    test('dto result is true when service returns true', function () use ($isVatPayerAction) {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$isVatPayerAction}Response xmlns="http://tempuri.org/">
      <{$isVatPayerAction}Result>true</{$isVatPayerAction}Result>
    </{$isVatPayerAction}Response>
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

describe('IsVatPayerRequest \u2014 mocked response: false', function () use ($isVatPayerAction) {

    test('dto result is false when service returns false', function () use ($isVatPayerAction) {
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <{$isVatPayerAction}Response xmlns="http://tempuri.org/">
      <{$isVatPayerAction}Result>false</{$isVatPayerAction}Result>
    </{$isVatPayerAction}Response>
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

describe('IsVatPayerTinRequest \u2014 XML body', function () use ($isVatPayerTinAction) {

    test('XML body contains tin param', function () use ($isVatPayerTinAction) {
        $request = new IsVatPayerTinRequest(['tin' => '12345678910']);
        $xml = $request->createXmlBodyFromParams();
        expect($xml)
            ->toContain($isVatPayerTinAction) // <is_vat_payer_tin ...>
            ->toContain('12345678910');
    });

});
