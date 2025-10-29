<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class WaybillTypeDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {}
}
