<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

use DateTimeImmutable;

/**
 * Wraps a single DateTimeImmutable value returned by the RS API.
 * Currently used by GetServerTimeRequest.
 */
class DateTimeDto
{
    public function __construct(
        public readonly DateTimeImmutable $value,
    ) {}
}
