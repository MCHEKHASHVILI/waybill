<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

use DateTimeImmutable;

class ExciseCode
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string|null $unit_name,
        public readonly int $code,
        public readonly float $rate,
        public readonly DateTimeImmutable $started_at,
        public readonly DateTimeImmutable|null $ended_at,
    ) {}
}
