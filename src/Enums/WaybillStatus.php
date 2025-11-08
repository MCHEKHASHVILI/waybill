<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

enum WaybillStatus: int
{
    case SAVED = 0;
    case ACTIVE = 1;
    case CLOSED = 2;
}
