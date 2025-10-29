<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class CheckServiceUserDto
{
    public function __construct(
        public readonly bool $active,
        public readonly int $tenant_id,
        public readonly int $user_id,
    ) {}
}
