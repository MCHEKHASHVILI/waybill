<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

use Mchekhashvili\RsWaybill\Traits\Enums\HasArray;
use Mchekhashvili\RsWaybill\Interfaces\Enums\HasArrayInterface;

enum EnvelopeNamespace: string implements HasArrayInterface
{
    use HasArray;
    case XSI = "http://www.w3.org/2001/XMLSchema-instance";
    case XSD = "http://www.w3.org/2001/XMLSchema";
    case SOAP = "http://schemas.xmlsoap.org/soap/envelope/";
}
