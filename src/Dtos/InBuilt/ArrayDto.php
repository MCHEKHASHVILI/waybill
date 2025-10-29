<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

class ArrayDto
{
    public function __construct(
        public readonly array $data,
    ) {}
}
