<?php

use DateTimeImmutable;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Enums\WaybillCategory;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;

test("Constructed from array", function () {
    $map = [
        "id" => "ID",
        "sub_waybills" => "SUB_WAYBILLS",
        "goods_list" => "GOODS_LIST",
        "type_id" => "TYPE",
        "buyer_tin" => "BUYER_TIN",
        "buyer_is_resident" => "CHEK_BUYER_TIN",
        "buyer_name" => "BUYER_NAME",
        "address_from" => "START_ADDRESS",
        "address_to" => "END_ADDRESS",
        "driver_tin" => "DRIVER_TIN",
        "driver_is_resident" => "CHEK_DRIVER_TIN",
        "driver_name" => "DRIVER_NAME",
        "delivery_cost" => "TRANSPORT_COAST",
        "supplier_info" => "RECEPTION_INFO",
        "receiver_info" => "RECEIVER_INFO",
        "delivery_date" => [
            "DELIVERY_DATE",
            function (array $val) {
                return isset($val["DELIVERY_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $val["DELIVERY_DATE"]) : null;
            }
        ],
        "status" => [
            "STATUS",
            function (array $val) {
                return isset($val["STATUS"]) ? WaybillStatus::from((int) $val["STATUS"]) : null;
            }
        ],
        "seller_tenant_id" => "SELER_UN_ID",
        "parent_id" => "PAR_ID",
        "full_amount" => "FULL_AMOUNT",
        "vehicle_state_number" => "CAR_NUMBER",
        "number" => "WAYBILL_NUMBER",
        "service_user_id" => "S_USER_ID",
        "send_at" => [
            "BEGIN_DATE",
            function (array $val) {
                return isset($val["BEGIN_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $val["BEGIN_DATE"]) : null;
            }
        ],
        "delivery_cost_payer" => [
            "TRAN_COST_PAYER",
            function (array $val) {
                return isset($val["TRAN_COST_PAYER"]) ? DeliveryCostPayer::from((int) $val["TRAN_COST_PAYER"]) : null;
            }
        ],
        "delivery_type_id" => "TRANS_ID",
        "delivery_type_name" => "TRANS_TXT",
        "comment" => "COMMENT",
        "category" => [
            "CATEGORY",
            function (array $val) {
                return isset($val["CATEGORY"]) ? WaybillCategory::from((int) $val["CATEGORY"]) : null;
            }
        ],
    ];
    $data = [
        "STATUS" => "0",
        "ID" => "976627249",
        "GOODS_LIST" => ""
    ];

    $waybillDto = WaybillDto::fromArray($data, $map);

    expect($waybillDto)->toBeInstanceOf(WaybillDto::class);
});
