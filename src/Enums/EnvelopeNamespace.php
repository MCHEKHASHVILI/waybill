<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Enums;

use Mchekhashvili\Rs\Waybill\Traits\Enums\HasArray;
use Mchekhashvili\Rs\Waybill\Interfaces\Enums\HasArrayInterface;

enum EnvelopeNamespace: string implements HasArrayInterface
{
    use HasArray;

    case XSI  = 'http://www.w3.org/2001/XMLSchema-instance';
    case XSD  = 'http://www.w3.org/2001/XMLSchema';
    case SOAP = 'http://schemas.xmlsoap.org/soap/envelope/';
}
