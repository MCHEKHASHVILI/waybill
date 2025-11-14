<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use DateTimeImmutable;
use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\ArrayDto;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillProductDto;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetWaybillGoodsListRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::GET_WAYBILL_GOODS_LIST;
    protected array $keyMap;
    public function __construct(protected mixed $params = [])
    {
        $this->keyMap = [
            "type_id" => "TYPE",
            "created_at" =>
            [
                "CREATE_DATE",
                fn(array $val) => isset($val["CREATE_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $val["CREATE_DATE"]) : null
            ],
            "activated_at" => [
                "ACTIVATE_DATE",
                fn(array $val) => isset($val["ACTIVATE_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $val["ACTIVATE_DATE"]) : null
            ],
            "delivery_date" => [
                "DELIVERY_DATE",
                fn(array $val) => isset($val["DELIVERY_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $val["DELIVERY_DATE"]) : null
            ],
            "closed_at" => [
                "CLOSE_DATE",
                fn(array $val) => isset($val["CLOSE_DATE"]) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $val["CLOSE_DATE"]) : null
            ],
            "buyer_tin" => "TIN",
            "buyer_name" => "BUYER_NAME",
            "address_from" => "START_ADDRESS",
            "address_to" => "END_ADDRESS",
            "driver_tin" => "DRIVER_TIN",
            "driver_name" => "DRIVER_NAME",
            "delivery_cost" => "TRANSPORT_COAST",
            "supplier_info" => "RECEPTION_INFO",
            "receiver_info" => "RECEIVER_INFO",
            "full_amount" => "FULL_AMOUNT",
            "vehicle_state_number" => "CAR_NUMBER",
            "waybill_number" => "WAYBILL_NUMBER",
            "delivery_cost_payer" => [
                "TRAN_COST_PAYER",
                fn(array $val) => isset($val["TRAN_COST_PAYER"]) ? DeliveryCostPayer::from((int) $val["TRAN_COST_PAYER"]) : null
            ],
            "delivery_type_id" => "TRANS_ID",
            "is_confirmed" => "",
            "status" => [
                "STATUS",
                fn(array $val) => isset($val["STATUS"]) ? WaybillStatus::from((int) $val["STATUS"]) : null
            ],
            "name" => "W_NAME",
            "unit_id" => "UNIT_ID",
            "quantity" => "QUANTITY",
            "price" => "PRICE",
            "amount" => "AMOUNT",
            "barcode" => "BAR_CODE",
            "id" => "ID",
        ];
    }

    public function createDtoFromResponse(Response $response): ArrayDto
    {
        $xmlArray = $response->xmlReader()->xpathValue("//WAYBILL_LIST/WAYBILL")->get();

        return new ArrayDto(
            data: array_reduce($xmlArray, function ($carry, $record) {
                $carry[] = WaybillProductDto::fromArray($record, $this->keyMap);
                return $carry;
            }, [])
        );
    }
}
