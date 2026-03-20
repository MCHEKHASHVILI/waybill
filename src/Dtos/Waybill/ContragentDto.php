<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Waybill;

final class ContragentDto
{
    public function __construct(
        public readonly int    $un_id,
        public readonly string $tin,
        public readonly string $name,
    ) {}
}
