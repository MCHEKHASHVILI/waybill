<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use Mchekhashvili\RsWaybill\Dtos\Static\ErrorCodeDto;

final class ErrorCodeMapper
{
    public static function fromXmlArray(array $data): ErrorCodeDto
    {
        return new ErrorCodeDto(
            id:      (int)    ($data['ID']   ?? 0),
            message: (string) ($data['TEXT'] ?? ''),
            type_id: isset($data['TYPE']) && $data['TYPE'] !== '' ? (int) $data['TYPE'] : null,
        );
    }
}
