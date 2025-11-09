<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class ProductDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $unit_id,
        public readonly string|null $unit_name,
        public readonly float $quantity,
        public readonly float $price,
        public readonly float $amount,
        public readonly string $bar_code,
        public readonly int $vat_type,
        public readonly int $status,
        public readonly float|null $quantity_ext,
    ) {}
}
