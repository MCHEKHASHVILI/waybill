<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use Mchekhashvili\RsWaybill\Dtos\Static\WaybillTypeDto;

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
