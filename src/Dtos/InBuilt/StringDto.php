<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

/**
 * Wraps a single string value returned by the RS API.
 * Used for responses that return a plain scalar (waybill number,
 * company name, IP address, payer type code, base64-encoded PDF, etc.).
 */
class StringDto
{
    public function __construct(
        public readonly string $value,
    ) {}
}
