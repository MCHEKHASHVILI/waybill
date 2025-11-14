<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

use DateTimeImmutable;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Enums\WaybillCategory;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;
use Mchekhashvili\RsWaybill\Traits\Dtos\HasConvertable;
use Mchekhashvili\RsWaybill\Interfaces\Dtos\ConvertableDtoInterface;

class WaybillDto implements ConvertableDtoInterface
{
    use HasConvertable;
    public function __construct(
        public readonly int $id,
        public readonly string $number,
        public readonly array|null $sub_waybills,
        public readonly array|null $goods_list,
        public readonly int|null $type_id,
        public readonly string|null $buyer_tin,
        public readonly bool|null $buyer_is_resident,
        public readonly string|null $buyer_name,
        public readonly string|null $address_from,
        public readonly string|null $address_to,
        public readonly int|null $driver_tin,
        public readonly bool|null $driver_is_resident,
        public readonly string|null $driver_name,
        public readonly float|null $delivery_cost,
        public readonly string|null $supplier_info,
        public readonly string|null $receiver_info,
        public readonly DateTimeImmutable|null $delivery_date,
        public readonly WaybillStatus|null $status,
        public readonly int|null $seller_tenant_id,
        public readonly int|null $parent_id,
        public readonly float|null $full_amount,
        public readonly string|null $vehicle_state_number,
        public readonly int|null $service_user_id,
        public readonly DateTimeImmutable|null $send_at,
        public readonly DeliveryCostPayer|null $delivery_cost_payer,
        public readonly int|null $delivery_type_id,
        public readonly string|null $delivery_type_name,
        public readonly string|null $comment,
        public readonly WaybillCategory|null $category,
    ) {}
}
