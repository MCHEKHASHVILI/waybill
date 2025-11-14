<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use DateTimeImmutable;
use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Enums\WaybillCategory;
use Mchekhashvili\RsWaybill\Dtos\Static\ProductDto;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetWaybillsAsBuyerExRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_BUYER_WAYBILLS_EX;
    protected array $keyMap;
    public function __construct(protected mixed $params = [])
    {
        $this->keyMap = [
            "id" => "ID",
            "sub_waybills" => "SUB_WAYBILLS",
            "goods_list" => [
                "GOODS_LIST",
                function (array $val) {
                    return array_reduce(
                        $val["GOODS_LIST"]["GOODS"],
                        function ($carry, $product) {
                            $carry[] = new ProductDto(
                                id: (int) $product["ID"],
                                name: (string) $product["W_NAME"],
                                unit_id: (int) $product["UNIT_ID"],
                                unit_name: (string) $product["UNIT_TXT"],
                                quantity: (float) $product["QUANTITY"],
                                price: (int) $product["PRICE"],
                                amount: (float) $product["AMOUNT"],
                                bar_code: (string) $product["BAR_CODE"],
                                vat_type: (int) $product["VAT_TYPE"],
                                status: (int) $product["STATUS"],
                                quantity_ext: isset($product["QUANTITY_F"]) ? (float) $product["QUANTITY_F"] : null
                            );

                            return $carry;
                        },
                        []
                    );
                }
            ],
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
    }

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        $xmlArray = $response->xmlReader()->xpathValue("//WAYBILL_LIST/WAYBILL")->get();

        return new ArrayDto(
            data: array_reduce($xmlArray, function ($carry, $waybill) {
                $carry[] = WaybillDto::fromArray($waybill, $this->keyMap);
                return $carry;
            })
        );
    }
}
