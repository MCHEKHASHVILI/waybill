<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Exceptions;

use LogicException;


class CollectionPropertyItemMustHaveNamedType extends LogicException
{
    protected $message = '$item property must have named type';
}
