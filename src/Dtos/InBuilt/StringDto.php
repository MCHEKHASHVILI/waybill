<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

class StringDto
{
    public function __construct(
        public readonly string $value,
    ) {}
}
