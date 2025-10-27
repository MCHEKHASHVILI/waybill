<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Interfaces\Enums;

interface HasArrayInterface
{
    /**
     * Converts backed enum to array
     * @return array
     */
    public static function toArray(): array;
}
