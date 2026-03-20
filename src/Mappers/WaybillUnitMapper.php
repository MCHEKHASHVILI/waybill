<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Mappers;

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillUnitDto;

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
