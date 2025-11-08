<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Static;

use Mchekhashvili\RsWaybill\Traits\Dtos\HasConvertable;
use Mchekhashvili\RsWaybill\Interfaces\Dtos\ConvertableDtoInterface;

class WaybillCreatedDto implements ConvertableDtoInterface
{
    use HasConvertable;
    public function __construct(
        public readonly int $id,
        public readonly string $number,
        public readonly array|null $sub_waybills,
        public readonly array|null $goods_list
    ) {}
}
