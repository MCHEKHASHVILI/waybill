<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Interfaces\Dtos;

interface ConvertableDtoInterface
{
    public static function fromArray(array $data, array $map): self;
    public static function toArray(): array;
    public static function toParams(array $map): array;
}
