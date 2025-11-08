<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

enum DeliveryCostPayer: int
{
    case BUYER = 1;
    case SELLER = 2;
}
