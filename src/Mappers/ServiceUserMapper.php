<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use Mchekhashvili\RsWaybill\Dtos\Static\ServiceUserDto;

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
