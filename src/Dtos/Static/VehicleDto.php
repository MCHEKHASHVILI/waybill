<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

final class VehicleDto
{
    public function __construct(
        public readonly string $state_number,
    ) {}
}
