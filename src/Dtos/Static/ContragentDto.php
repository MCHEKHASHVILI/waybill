<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class ContragentDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $tin,
        public readonly string $name,
    ) {}
}
