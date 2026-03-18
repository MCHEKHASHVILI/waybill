<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Traits\Dtos;

/**
 * @deprecated Use dedicated Mapper classes instead (src/Mappers/).
 * This trait is retained only for backward compatibility and will be removed in a future version.
 */
trait HasConvertable
{
    public static function fromArray(array $data, array $map): self
    {
        throw new \LogicException(
            static::class . ' uses the deprecated HasConvertable trait. '
            . 'Use the corresponding Mapper class in Mchekhashvili\\RsWaybill\\Mappers\\ instead.'
        );
    }

    public static function toArray(): array
    {
        throw new \LogicException(
            static::class . ' uses the deprecated HasConvertable trait. '
            . 'Use the corresponding Mapper class in Mchekhashvili\\RsWaybill\\Mappers\\ instead.'
        );
    }

    public static function toParams(array $map): array
    {
        throw new \LogicException(
            static::class . ' uses the deprecated HasConvertable trait. '
            . 'Use the corresponding Mapper class in Mchekhashvili\\RsWaybill\\Mappers\\ instead.'
        );
    }
}
