<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

use DateTimeImmutable;

final class ExciseCodeDto
{
    public function __construct(
        public readonly int                    $id,
        public readonly string                 $name,
        public readonly string|null            $unit_name,
        public readonly int                    $code,
        public readonly float                  $rate,
        public readonly DateTimeImmutable|null $started_at,
        public readonly DateTimeImmutable|null $ended_at,
    ) {}
}
