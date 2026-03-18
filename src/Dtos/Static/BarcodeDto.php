<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

final class BarcodeDto
{
    public function __construct(
        public readonly string      $code,
        public readonly string      $name,
        public readonly int         $unit_id,
        public readonly string|null $unit_name,
    ) {}
}
