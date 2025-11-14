<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

enum WaybillStatus: int
{
    case DELETED = -1;
    case CANCELLED = -2;
    case SAVED = 0;
    case ACTIVE = 1;
    case CLOSED = 2;
    case SENT_TO_TRANSPORTER = 8;
}
