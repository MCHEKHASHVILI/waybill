<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class ErrorCodeDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $message,
        public readonly int|null $type_id,
    ) {}
}
