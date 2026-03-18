<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use Mchekhashvili\RsWaybill\Dtos\Static\WaybillUnitDto;

final class WaybillUnitMapper
{
    public static function fromXmlArray(array $data): WaybillUnitDto
    {
        return new WaybillUnitDto(
            id:   (int)    ($data['ID']   ?? 0),
            name: (string) ($data['NAME'] ?? ''),
        );
    }
}
