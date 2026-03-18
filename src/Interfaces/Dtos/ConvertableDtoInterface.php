<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Interfaces\Dtos;

/**
 * @deprecated Mapping is now handled by dedicated Mapper classes in Mchekhashvili\RsWaybill\Mappers.
 * This interface will be removed in a future version.
 */
interface ConvertableDtoInterface
{
    public static function fromArray(array $data, array $map): self;
    public static function toArray(): array;
    public static function toParams(array $map): array;
}
