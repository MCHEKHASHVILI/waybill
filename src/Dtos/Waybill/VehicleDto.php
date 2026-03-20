<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Waybill;

final class VehicleDto
{
    public function __construct(
        public readonly string $state_number,
    ) {}
}
