<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Interfaces\Dtos;

interface ConvertableToParamsInterface
{
    public function convertToParams(): array;
}
