<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Dtos\Waybill;

/**
 * Returned by createWaybill() and updateWaybill() on success.
 *
 * The RS API wraps the result in <RESULT> containing:
 *   STATUS          — 0 on success, negative integer error code on failure
 *   ID              — assigned waybill ID
 *   WAYBILL_NUMBER  — assigned waybill number (only present after activation)
 *   GOODS_LIST      — per-item results, each with an ERROR field
 *
 * A negative STATUS causes the request class to throw WaybillRequestException
 * before this DTO is constructed, so a successfully constructed instance always
 * represents a saved waybill.
 *
 * goodsErrors is a map of goods-line index (0-based) => RS error code integer
 * for any product lines that had validation errors. This is only populated
 * when STATUS === 0 (waybill saved) but some goods lines individually failed.
 */
final class WaybillCreatedDto
{
    /**
     * @param array<int, int> $goodsErrors  index => RS error code
     */
    public function __construct(
        public readonly int    $id,
        public readonly string $number,
        public readonly array  $goodsErrors = [],
    ) {}

    /**
     * Returns true if all goods lines were saved without per-item errors.
     */
    public function hasGoodsErrors(): bool
    {
        return count($this->goodsErrors) > 0;
    }
}
