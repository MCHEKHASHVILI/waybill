<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Exceptions;

use LogicException;


class TryingToSetInvalidDtoException extends LogicException
{
    protected $message = 'You are trying to set unrelated item to collection';
}
