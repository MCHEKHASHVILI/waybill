<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class ServiceUserDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $username,
        public readonly int $tenant_id,
        public readonly string $name,
    ) {}
}
