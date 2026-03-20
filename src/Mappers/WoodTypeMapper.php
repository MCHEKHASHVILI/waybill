<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Mappers;

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WoodTypeDto;

final class WoodTypeMapper
{
    public static function fromXmlArray(array $data): WoodTypeDto
    {
        return new WoodTypeDto(
            id:          (int)    ($data['ID']   ?? 0),
            name:        (string) ($data['NAME'] ?? ''),
            description: isset($data['DESCRIPTION']) && $data['DESCRIPTION'] !== ''
                            ? (string) $data['DESCRIPTION']
                            : null,
        );
    }
}
