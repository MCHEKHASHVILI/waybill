<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Exceptions;

use LogicException;
use Mchekhashvili\Rs\Waybill\Enums\Action;

class ActionPropertyIsNotSetException extends LogicException
{
    protected $message = 'Your request is missing a SOAP action. Add a property like [protected '
        . Action::class
        . ' $action = Action::CHECK_SERVICE_USER]';
}
