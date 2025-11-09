<?php

use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Requests\UpdateWaybillRequest;
use Mchekhashvili\RsWaybill\Connectors\WaybillServiceConnector;

test("returned response is an array of " . WaybillDto::class, function () {
    $data = [
        "waybill" => [
            "WAYBILL" => [
                "ID" => "978941382",
                "SUB_WAYBILLS" => [],
                "GOODS_LIST" => [
                    ["GOODS" => [
                        "ID" => "1",
                        "W_NAME" => "ფარი უნივერსალური Техно ST120 0.95х3.0",
                        "UNIT_ID" => "1",
                        "UNIT_TXT" => "",
                        "QUANTITY" => "2",
                        "PRICE" => "10",
                        "AMOUNT" => "20",
                        "BAR_CODE" => "999908ძ",
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
                "DELIVERY_DATE" => "2025-11-11T18:13:59",
                "STATUS" => "0",
                "SELER_UN_ID" => "731937",
                "PAR_ID" => "",
                "FULL_AMOUNT" => "20",
                "CAR_NUMBER" => "ADA123",
                "WAYBILL_NUMBER" => "",
                "S_USER_ID" => 783,
                "BEGIN_DATE" => "2025-11-10T18:13:59",
                "TRAN_COST_PAYER" => "2",
                "TRANS_ID" => "1",
                "TRANS_TXT" =>  "",
                "COMMENT" => "updated",
                "CATEGORY" => "",
            ]
        ]
    ];

    $response = (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
        ->send(new UpdateWaybillRequest($data));

    $dto = $response->dto();
    // dd($response->getPendingRequest()->body());
    // dd($response->body());
    expect($dto)->toBeInstanceOf(WaybillDto::class);
});
