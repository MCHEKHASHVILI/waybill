<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Exceptions;

use LogicException;
use Mchekhashvili\RsWaybill\Enums\Action;


class ActionPropertyIsNotSetException extends LogicException
{
    protected $message = 'Your request is missing a SOAP action. You must add an action property like [protected ' . Action::class . ' $action = Action::CHECK_SERVICE_USER]';
}
