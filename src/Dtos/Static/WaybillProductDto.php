<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

use DateTimeImmutable;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;
use Mchekhashvili\RsWaybill\Traits\Dtos\HasConvertable;
use Mchekhashvili\RsWaybill\Interfaces\Dtos\ConvertableDtoInterface;

class WaybillProductDto implements ConvertableDtoInterface
{
    use HasConvertable;
    public function __construct(
        public readonly int|null $type_id, // <TYPE>6</TYPE>
        public readonly DateTimeImmutable $created_at, // <CREATE_DATE>2012-02-14T02:39:57</CREATE_DATE>
        public readonly DateTimeImmutable|null $activated_at, // <ACTIVATE_DATE>2012-02-14T02:39:57</ACTIVATE_DATE>
        public readonly DateTimeImmutable|null $delivery_date, // <DELIVERY_DATE>2012-02-14T02:12:22</DELIVERY_DATE>
        public readonly DateTimeImmutable|null $closed_at, // <CLOSE_DATE>2012-07-06T02:41:04</CLOSE_DATE>
        public readonly string|null $buyer_tin, // <TIN>202450640</TIN>
        public readonly string $buyer_name, // <NAME>შპს ჯორჯიან ბეიქერს</NAME>
        public readonly string $address_from, // <START_ADDRESS>Start location</START_ADDRESS>
        public readonly string $address_to, // <END_ADDRESS>End Location</END_ADDRESS>
        public readonly int|null $driver_tin, // <DRIVER_TIN>60001036898</DRIVER_TIN>
        public readonly string|null $driver_name, // <DRIVER_NAME>1</DRIVER_NAME>
        public readonly float|null $delivery_cost, // <TRANSPORT_COAST>0</TRANSPORT_COAST>
        public readonly string|null $supplier_info, // <RECEPTION_INFO>Supplier</RECEPTION_INFO>
        public readonly string|null $receiver_info, // <RECEIVER_INFO>Receiver</RECEIVER_INFO>
        public readonly float|null $full_amount, // <FULL_AMOUNT>1</FULL_AMOUNT>
        public readonly string|null $vehicle_state_number, // <CAR_NUMBER>mix909</CAR_NUMBER>
        public readonly string $waybill_number, // <WAYBILL_NUMBER>0000001281/8</WAYBILL_NUMBER>
        public readonly DeliveryCostPayer|null $delivery_cost_payer, // <TRAN_COST_PAYER>0</TRAN_COST_PAYER>
        public readonly int|null $delivery_type_id, // <TRANS_ID>1</TRANS_ID>
        public readonly bool $is_confirmed, // <IS_CONFIRMED>0</IS_CONFIRMED>
        public readonly WaybillStatus|null $status, // <STATUS>-2</STATUS>
        public readonly string $name, // <W_NAME>Product1</W_NAME>
        public readonly string $unit_id, // <UNIT_ID>1</UNIT_ID>
        public readonly string $quantity, // <QUANTITY>1</QUANTITY>
        public readonly string $price, // <PRICE>1</PRICE>
        public readonly string $amount, // <AMOUNT>1</AMOUNT>
        public readonly string $barcode, // <BAR_CODE>1</BAR_CODE>
        public readonly string $id // <ID>3722</ID>
    ) {}
}
