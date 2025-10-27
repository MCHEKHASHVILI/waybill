<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\Convertable;

use Carbon\Carbon;
use Mchekhashvili\RsWaybill\Interfaces\Dtos\ConvertableToParamsInterface;

class ExciseCode implements ConvertableToParamsInterface
{
    public function __construct(
        public readonly int|null $id = null,
        public readonly string|null $name = null,
        public readonly string|null $unit_name = null,
        public readonly int|null $code = null,
        public readonly float|null $rate = null,
        public readonly Carbon|null $started_at = null,
        public readonly Carbon|null $ended_at = null,
        public string|null $search = null
    ) {}

    public function convertToParams(): array
    {
        return [
            "s_text" => $this->search
        ];
    }
}
