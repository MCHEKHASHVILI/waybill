<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use DateTimeImmutable;
use Mchekhashvili\RsWaybill\Dtos\Static\ExciseCodeDto;

final class ExciseCodeMapper
{
    public static function fromXmlArray(array $data): ExciseCodeDto
    {
        return new ExciseCodeDto(
            id:         (int)    ($data['ID']          ?? 0),
            name:       (string) ($data['TITLE']       ?? ''),
            unit_name:  isset($data['MEASUREMENT']) && $data['MEASUREMENT'] !== '' ? (string) $data['MEASUREMENT'] : null,
            code:       (int)    ($data['SAKON_KODI']  ?? 0),
            rate:       (float)  ($data['AKCIS_GANAKV'] ?? 0),
            started_at: !empty($data['START_DATE']) ? DateTimeImmutable::createFromFormat('Y-m-d', $data['START_DATE']) ?: null : null,
            ended_at:   !empty($data['END_DATE'])   ? DateTimeImmutable::createFromFormat('Y-m-d', $data['END_DATE'])   ?: null : null,
        );
    }
}
