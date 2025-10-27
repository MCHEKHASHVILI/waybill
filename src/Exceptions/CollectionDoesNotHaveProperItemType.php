<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Exceptions;

use LogicException;


class CollectionDoesNotHaveProperItemType extends LogicException
{
    protected $message = 'Your collection must have $item type of dto';
}
