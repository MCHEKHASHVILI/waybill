<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Primitives;

/**
 * Wraps a single boolean result returned by the RS API.
 * Used for confirmation and existence-check responses.
 */
class BooleanDto
{
    public function __construct(
        public readonly bool $result,
    ) {}
}
