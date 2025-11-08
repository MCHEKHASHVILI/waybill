<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Interfaces\Requests;

interface CatchesBadResponseInterface
{
    public function catchErrorInResponse(): string;
}
