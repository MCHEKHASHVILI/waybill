<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

enum AuthMethod
{
    case GUEST;
    case TENANT;
    case SERVICE_USER;
}
