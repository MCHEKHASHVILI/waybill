<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

class WhatIsMyIp
{
    public function __construct(
        public readonly string $ip,
    ) {}
}
