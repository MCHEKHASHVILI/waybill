<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Mappers;

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ServiceUserDto;

final class ServiceUserMapper
{
    public static function fromXmlArray(array $data): ServiceUserDto
    {
        return new ServiceUserDto(
            id:        (int)    ($data['ID']        ?? 0),
            username:  (string) ($data['USER_NAME'] ?? ''),
            tenant_id: (int)    ($data['UN_ID']     ?? 0),
            name:      (string) ($data['NAME']      ?? ''),
        );
    }
}
