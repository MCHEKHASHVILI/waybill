<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

use DateTimeImmutable;

class DateTimeDto
{
    public function __construct(
        public readonly DateTimeImmutable $value,
    ) {}
}
