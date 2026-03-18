<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use Mchekhashvili\RsWaybill\Dtos\Static\TransportationTypeDto;

final class TransportationTypeMapper
{
    public static function fromXmlArray(array $data): TransportationTypeDto
    {
        return new TransportationTypeDto(
            id:   (int)    ($data['ID']   ?? 0),
            name: (string) ($data['NAME'] ?? ''),
        );
    }
}
