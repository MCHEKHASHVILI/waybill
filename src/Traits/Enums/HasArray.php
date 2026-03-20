<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Traits\Enums;

trait HasArray
{
    public static function toArray(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[strtolower($case->name)] = $case->value;
            return $carry;
        }, []);
    }
}
