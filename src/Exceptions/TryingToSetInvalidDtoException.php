<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Exceptions;

use InvalidArgumentException;

class TryingToSetInvalidDtoException extends InvalidArgumentException
{
    protected $message = 'You are trying to set an unrelated item in a collection.';
}
