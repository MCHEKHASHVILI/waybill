<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class CheckServiceUser
{
    public function __construct(
        public readonly bool $registered,
        public readonly int $tenant_id,
        public readonly int $user_id,
    ) {}
}
