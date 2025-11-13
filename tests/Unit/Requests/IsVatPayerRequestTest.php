<?php

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Requests\IsVatPayerRequest;
use Mchekhashvili\RsWaybill\Requests\IsVatPayerTinRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;


describe("invalid inputs", function () {
    test("Vat payer using un_id: Returns " . BooleanDto::class, function () {
        $response = (new WaybillServiceConnector())->send(new IsVatPayerRequest(
            [
                'un_id' => '123456'
            ]
        ));
        $dto = $response->dto();
        expect($dto)->toBeInstanceOf(BooleanDto::class);
        expect($dto)->toHaveProperty("result");
        expect($dto->result)->toBeFalse("is vat payer");
    })->skip();

    test("Vat payer using tin: Returns " . BooleanDto::class, function () {
        $response = (new WaybillServiceConnector())->send(new IsVatPayerTinRequest(
            [
                'tin' => '123456'
            ]
        ));
        $dto = $response->dto();
        expect($dto)->toBeInstanceOf(BooleanDto::class);
        expect($dto)->toHaveProperty("result");
        expect($dto->result)->toBeFalse("is vat payer");
    })->skip();
});
describe("valid inputs", function () {
    test("Vat payer using un_id: Returns " . BooleanDto::class, function () {
        $response = (new WaybillServiceConnector())->send(new IsVatPayerRequest(
            [
                'un_id' => '731937'
            ]
        ));
        $dto = $response->dto();
        expect($dto)->toBeInstanceOf(BooleanDto::class);
        expect($dto)->toHaveProperty("result");
        expect($dto->result)->toBeFalse("is vat payer");
    });

    test("Vat payer using tin: Returns " . BooleanDto::class, function () {
        $response = (new WaybillServiceConnector())->send(new IsVatPayerTinRequest(
            [
                'tin' => '12345678910'
            ]
        ));
        $dto = $response->dto();
        expect($dto)->toBeInstanceOf(BooleanDto::class);
        expect($dto)->toHaveProperty("result");
        expect($dto->result)->toBeFalse("is vat payer");
    });
});
