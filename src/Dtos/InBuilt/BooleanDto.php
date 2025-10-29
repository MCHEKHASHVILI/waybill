<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

class BooleanDto
{
    public function __construct(
        public readonly bool $result,
    ) {}
}
