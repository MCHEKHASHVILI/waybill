<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Mappers;

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\BarcodeDto;

final class BarcodeMapper
{
    public static function fromXmlArray(array $data): BarcodeDto
    {
        return new BarcodeDto(
            code:      (string) ($data['CODE']    ?? ''),
            name:      (string) ($data['NAME']    ?? ''),
            unit_id:   (int)    ($data['UNIT_ID'] ?? 0),
            unit_name: isset($data['UNIT_TXT']) && $data['UNIT_TXT'] !== '' ? (string) $data['UNIT_TXT'] : null,
        );
    }
}
