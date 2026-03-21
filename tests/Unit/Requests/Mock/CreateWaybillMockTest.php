<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillCreatedDto;
use Mchekhashvili\Rs\Waybill\Requests\CreateWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillServerException;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillRequestException;

$action = Action::SAVE_WAYBILL->value; // 'save_waybill'

describe('CreateWaybillRequest — XML body', function () use ($action) {

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
            ->toContain($action)
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

describe('CreateWaybillRequest — mocked response', function () use ($action) {

    test('createDtoFromResponse returns a WaybillCreatedDto on success', function () use ($action) {
        // The RS API wraps the save_waybill result in <RESULT>:
        //   <save_waybillResult><RESULT><STATUS>0</STATUS><ID>...</ID>...</RESULT></save_waybillResult>
        $mockXml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <{$action}Response xmlns="http://tempuri.org/">
            <{$action}Result>
                <RESULT>
                    <STATUS>0</STATUS>
                    <ID>99999</ID>
                    <WAYBILL_NUMBER>WB-TEST-001</WAYBILL_NUMBER>
                    <GOODS_LIST></GOODS_LIST>
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
expect($dto->hasGoodsErrors())->toBeFalse();
});

test('WaybillRequestException is thrown when RESULT STATUS is a non-zero error code', function () use ($action) {
// STATUS = -1001 means "invalid waybill type".
// createDtoFromResponse() reads STATUS from <RESULT> and throws WaybillRequestException.
    // Note: ->dto() must be called to trigger createDtoFromResponse().
    $mockXml = <<<XML <?xml version="1.0" encoding="utf-8" ?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <{$action}Response xmlns="http://tempuri.org/">
                    <{$action}Result>
                        <RESULT>
                            <STATUS>-1001</STATUS>
                            <ID>0</ID>
                            <GOODS_LIST></GOODS_LIST>
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

        // ->dto() triggers createDtoFromResponse() which reads STATUS and throws
        expect(fn() => $connector->send(new CreateWaybillRequest([]))->dto())
        ->toThrow(WaybillRequestException::class);
        });

        test('hasRequestFailed throws WaybillServerException when RS returns an HTML error page', function () {
        // In Saloon v3, hasRequestFailed() is called from Response::throw(), which Saloon
        // only invokes for non-2xx responses. Since RS always returns HTTP 200 (even for
        // error pages), we test hasRequestFailed() directly on a mock Response.
        // This correctly verifies the guard logic without depending on Saloon's call chain.
        $htmlBody = '<html>

        <head>
            <title>Runtime Error</title>
        </head>

        <body>
            <h1>Server Error</h1>
        </body>

        </html>';

        $mockClient = new MockClient([
        CreateWaybillRequest::class => MockResponse::make($htmlBody, 200, ['Content-Type' => 'text/html']),
        ]);

        $connector = new WaybillServiceConnector();
        $connector->withMockClient($mockClient);

        $request = new CreateWaybillRequest([]);
        $response = $connector->send($request);

        expect(fn() => $request->hasRequestFailed($response))
        ->toThrow(WaybillServerException::class);
        });

        });