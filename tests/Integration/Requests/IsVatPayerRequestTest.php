<?php

use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Requests\IsVatPayerRequest;
use Mchekhashvili\Rs\Waybill\Requests\IsVatPayerTinRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;


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
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

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
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
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
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');

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
    })->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
});
