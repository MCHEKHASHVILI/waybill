<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Traits\Enums;

trait HasArray
{
    /**
     * Converts backed enum to array
     * @return array
     */
    public static function toArray(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[strtolower($case->name)] = $case->value;
            return $carry;
        }, []);
    }
}
