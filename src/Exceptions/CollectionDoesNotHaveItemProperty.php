<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Exceptions;

use LogicException;


class CollectionDoesNotHaveItemProperty extends LogicException
{
    protected $message = 'Your collection must have $item property';
}
