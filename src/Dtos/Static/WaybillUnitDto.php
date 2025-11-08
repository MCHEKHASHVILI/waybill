<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

use Mchekhashvili\RsWaybill\Traits\Dtos\HasConvertable;
use Mchekhashvili\RsWaybill\Interfaces\Dtos\ConvertableDtoInterface;

class WaybillUnitDto implements ConvertableDtoInterface
{
    use HasConvertable;
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {}
}
