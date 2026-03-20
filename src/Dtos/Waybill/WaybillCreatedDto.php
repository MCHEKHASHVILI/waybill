<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Waybill;

final class WaybillCreatedDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $number,
    ) {}
}
