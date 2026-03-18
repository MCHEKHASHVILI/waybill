<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use Mchekhashvili\RsWaybill\Dtos\Static\ProductDto;

final class ProductMapper
{
    public static function fromXmlArray(array $data): ProductDto
    {
        return new ProductDto(
            id:           (int)    ($data['ID']         ?? 0),
            name:         (string) ($data['W_NAME']     ?? ''),
            unit_id:      (int)    ($data['UNIT_ID']    ?? 0),
            unit_name:    isset($data['UNIT_TXT']) && $data['UNIT_TXT'] !== '' ? (string) $data['UNIT_TXT'] : null,
            quantity:     (float)  ($data['QUANTITY']   ?? 0),
            price:        (float)  ($data['PRICE']      ?? 0),
            amount:       (float)  ($data['AMOUNT']     ?? 0),
            bar_code:     (string) ($data['BAR_CODE']   ?? ''),
            vat_type:     (int)    ($data['VAT_TYPE']   ?? 0),
            status:       (int)    ($data['STATUS']     ?? 0),
            quantity_ext: isset($data['QUANTITY_F']) && $data['QUANTITY_F'] !== '' ? (float) $data['QUANTITY_F'] : null,
        );
    }

    /**
     * Maps a raw XML collection to an array of ProductDto.
     * Handles both a flat list and a nested GOODS wrapper.
     *
     * @return ProductDto[]
     */
    public static function fromXmlCollection(mixed $raw): array
    {
        if (empty($raw)) {
            return [];
        }

        // Some endpoints nest products under GOODS_LIST > GOODS
        if (isset($raw['GOODS']) && is_array($raw['GOODS'])) {
            $raw = $raw['GOODS'];
        }

        // Single product comes as an assoc array, not a list
        if (isset($raw['ID'])) {
            return [self::fromXmlArray($raw)];
        }

        return array_values(array_map(
            fn(array $item) => self::fromXmlArray($item),
            $raw
        ));
    }
}
