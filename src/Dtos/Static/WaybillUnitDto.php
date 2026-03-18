<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

final class WaybillUnitDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
    ) {}
}
