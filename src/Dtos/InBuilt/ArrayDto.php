<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Dtos\InBuilt;

/**
 * Generic collection wrapper.
 *
 * $data always contains objects of a single concrete DTO type.
 * The @var docblock on each usage documents the concrete type.
 * Example: @var WaybillDto[] $dto->data
 */
class ArrayDto
{
    public function __construct(
        /** @var object[] */
        public readonly array $data,
    ) {}
}
