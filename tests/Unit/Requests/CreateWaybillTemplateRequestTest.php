<?php

use Mchekhashvili\RsWaybill\Dtos\Static\WaybillCreatedDto;
use Mchekhashvili\RsWaybill\Requests\CreateWaybillTemplateRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("This function does not work and returns error 500 from server", function () {
    $data = [
        "v_name" => "test",
        "waybill" => [
            "WAYBILL" => [
                "ID" => "",
                "SUB_WAYBILLS" => [],
                "GOODS_LIST" => [
                    ["GOODS" => [
                        "ID" => "",
                        "W_NAME" => "კჯუ8იმჯუი",
                        "UNIT_ID" => "1",
                        "UNIT_TXT" => "",
                        "QUANTITY" => "2",
                        "PRICE" => "10",
                        "AMOUNT" => "20",
                        "BAR_CODE" => "00001",
                        "VAT_TYPE" => "1",
                        "STATUS" => "1",
                        "QUANTITY_F" => "0"
                    ]]
                ],
                "TYPE" => "2",
                "BUYER_TIN" => "12345678910",
                "CHEK_BUYER_TIN" => "1",
                "BUYER_NAME" => "შპს რემმშენი",
                "START_ADDRESS" => "აგლაძის ქ. 32",
                "END_ADDRESS" => "ჯავახეთის ქ.12a",
                "DRIVER_TIN" => "12345678910",
                "CHEK_DRIVER_TIN" => "1",
                "DRIVER_NAME" => "Revazi",
                "TRANSPORT_COAST" => "1000",
                "RECEPTION_INFO" => "",
                "RECEIVER_INFO" => "",
                "DELIVERY_DATE" => "",
                "STATUS" => "0",
                "SELER_UN_ID" => "731937",
                "PAR_ID" => "",
                "FULL_AMOUNT" => "4",
                "CAR_NUMBER" => "ADA123",
                "WAYBILL_NUMBER" => "",
                "S_USER_ID" => "783",
                "BEGIN_DATE" => "2021-02-09T18:13:59",
                "TRAN_COST_PAYER" => "2",
                "TRANS_ID" => "1",
                "TRANS_TXT" =>  "",
                "COMMENT" => "manqana 1",
                "CATEGORY" => "",
            ]
        ]
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new CreateWaybillTemplateRequest($data));

    expect($response->status())->toBe(500);
});
