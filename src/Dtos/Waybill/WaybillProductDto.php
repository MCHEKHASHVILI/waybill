<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Waybill;

use DateTimeImmutable;
use Mchekhashvili\Rs\Waybill\Enums\WaybillStatus;
use Mchekhashvili\Rs\Waybill\Enums\DeliveryCostPayer;

final class WaybillProductDto
{
    public function __construct(
        public readonly int                    $id,
        public readonly string                 $waybill_number,
        public readonly string                 $name,
        public readonly int                    $unit_id,
        public readonly float                  $quantity,
        public readonly float                  $price,
        public readonly float                  $amount,
        public readonly string                 $barcode,
        public readonly bool                   $is_confirmed,
        public readonly int|null               $type_id,
        public readonly string|null            $buyer_tin,
        public readonly string|null            $buyer_name,
        public readonly string|null            $address_from,
        public readonly string|null            $address_to,
        public readonly int|null               $driver_tin,
        public readonly string|null            $driver_name,
        public readonly float|null             $delivery_cost,
        public readonly string|null            $supplier_info,
        public readonly string|null            $receiver_info,
        public readonly float|null             $full_amount,
        public readonly string|null            $vehicle_state_number,
        public readonly DeliveryCostPayer|null $delivery_cost_payer,
        public readonly int|null               $delivery_type_id,
        public readonly WaybillStatus|null     $status,
        public readonly DateTimeImmutable|null $created_at,
        public readonly DateTimeImmutable|null $activated_at,
        public readonly DateTimeImmutable|null $delivery_date,
        public readonly DateTimeImmutable|null $closed_at,
    ) {}
}
