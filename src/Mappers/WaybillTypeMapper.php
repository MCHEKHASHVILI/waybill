<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Mappers;

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillTypeDto;

final class WaybillTypeMapper
{
    public static function fromXmlArray(array $data): WaybillTypeDto
    {
        return new WaybillTypeDto(
            id:   (int)    ($data['ID']   ?? 0),
            name: (string) ($data['NAME'] ?? ''),
        );
    }
}
