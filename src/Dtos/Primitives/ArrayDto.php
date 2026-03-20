<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Primitives;

/**
 * Generic collection wrapper.
 *
 * $data always contains objects of a single concrete DTO type.
 * Example: @var WaybillDto[] $dto->data
 */
class ArrayDto
{
    public function __construct(
        /** @var object[] */
        public readonly array $data,
    ) {}
}
