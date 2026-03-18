<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Mappers;

use DateTimeImmutable;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Enums\WaybillCategory;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;

final class WaybillMapper
{
    public static function fromXmlArray(array $data): WaybillDto
    {
        return new WaybillDto(
            id:                   (int)    ($data['ID']             ?? 0),
            number:               (string) ($data['WAYBILL_NUMBER'] ?? ''),
            sub_waybills:         !empty($data['SUB_WAYBILLS']) ? (array) $data['SUB_WAYBILLS'] : null,
            goods_list:           !empty($data['GOODS_LIST'])   ? ProductMapper::fromXmlCollection($data['GOODS_LIST']) : [],
            type_id:              self::int($data,   'TYPE'),
            buyer_tin:            self::str($data,   'BUYER_TIN'),
            buyer_is_resident:    self::bool($data,  'CHEK_BUYER_TIN'),
            buyer_name:           self::str($data,   'BUYER_NAME'),
            address_from:         self::str($data,   'START_ADDRESS'),
            address_to:           self::str($data,   'END_ADDRESS'),
            driver_tin:           self::int($data,   'DRIVER_TIN'),
            driver_is_resident:   self::bool($data,  'CHEK_DRIVER_TIN'),
            driver_name:          self::str($data,   'DRIVER_NAME'),
            delivery_cost:        self::float($data, 'TRANSPORT_COAST'),
            supplier_info:        self::str($data,   'RECEPTION_INFO'),
            receiver_info:        self::str($data,   'RECEIVER_INFO'),
            delivery_date:        self::datetime($data, 'DELIVERY_DATE'),
            status:               self::present($data, 'STATUS')
                                    ? WaybillStatus::tryFrom((int) $data['STATUS'])
                                    : null,
            seller_tenant_id:     self::int($data,   'SELER_UN_ID'),
            parent_id:            self::int($data,   'PAR_ID'),
            full_amount:          self::float($data, 'FULL_AMOUNT'),
            vehicle_state_number: self::str($data,   'CAR_NUMBER'),
            service_user_id:      self::int($data,   'S_USER_ID'),
            send_at:              self::datetime($data, 'BEGIN_DATE'),
            delivery_cost_payer:  self::present($data, 'TRAN_COST_PAYER')
                                    ? DeliveryCostPayer::tryFrom((int) $data['TRAN_COST_PAYER'])
                                    : null,
            delivery_type_id:     self::int($data,   'TRANS_ID'),
            delivery_type_name:   self::str($data,   'TRANS_TXT'),
            comment:              self::str($data,   'COMMENT'),
            category:             self::present($data, 'CATEGORY')
                                    ? WaybillCategory::tryFrom((int) $data['CATEGORY'])
                                    : null,
        );
    }

    /**
     * Serialise a WaybillDto back to the flat params array the RS SOAP API expects.
     * Null values are omitted so the API uses its own defaults.
     */
    public static function toParams(WaybillDto $dto): array
    {
        return array_filter([
            'ID'              => $dto->id ?: null,
            'WAYBILL_NUMBER'  => $dto->number ?: null,
            'SUB_WAYBILLS'    => $dto->sub_waybills,
            'TYPE'            => $dto->type_id,
            'BUYER_TIN'       => $dto->buyer_tin,
            'CHEK_BUYER_TIN'  => $dto->buyer_is_resident !== null ? (int) $dto->buyer_is_resident : null,
            'BUYER_NAME'      => $dto->buyer_name,
            'START_ADDRESS'   => $dto->address_from,
            'END_ADDRESS'     => $dto->address_to,
            'DRIVER_TIN'      => $dto->driver_tin,
            'CHEK_DRIVER_TIN' => $dto->driver_is_resident !== null ? (int) $dto->driver_is_resident : null,
            'DRIVER_NAME'     => $dto->driver_name,
            'TRANSPORT_COAST' => $dto->delivery_cost,
            'RECEPTION_INFO'  => $dto->supplier_info,
            'RECEIVER_INFO'   => $dto->receiver_info,
            'DELIVERY_DATE'   => $dto->delivery_date?->format("Y-m-d\TH:i:s"),
            'STATUS'          => $dto->status?->value,
            'SELER_UN_ID'     => $dto->seller_tenant_id,
            'PAR_ID'          => $dto->parent_id,
            'FULL_AMOUNT'     => $dto->full_amount,
            'CAR_NUMBER'      => $dto->vehicle_state_number,
            'S_USER_ID'       => $dto->service_user_id,
            'BEGIN_DATE'      => $dto->send_at?->format("Y-m-d\TH:i:s"),
            'TRAN_COST_PAYER' => $dto->delivery_cost_payer?->value,
            'TRANS_ID'        => $dto->delivery_type_id,
            'TRANS_TXT'       => $dto->delivery_type_name,
            'COMMENT'         => $dto->comment,
            'CATEGORY'        => $dto->category?->value,
        ], fn($v) => $v !== null);
    }

    // ---------------------------------------------------------------------------
    // Private helpers — remove the isset/!== '' boilerplate from every field
    // ---------------------------------------------------------------------------

    private static function present(array $data, string $key): bool
    {
        return isset($data[$key]) && $data[$key] !== '';
    }

    private static function str(array $data, string $key): ?string
    {
        return self::present($data, $key) ? (string) $data[$key] : null;
    }

    private static function int(array $data, string $key): ?int
    {
        return self::present($data, $key) ? (int) $data[$key] : null;
    }

    private static function float(array $data, string $key): ?float
    {
        return self::present($data, $key) ? (float) $data[$key] : null;
    }

    private static function bool(array $data, string $key): ?bool
    {
        return self::present($data, $key) ? (bool)(int) $data[$key] : null;
    }

    private static function datetime(array $data, string $key): ?DateTimeImmutable
    {
        if (! self::present($data, $key)) {
            return null;
        }
        return DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data[$key]) ?: null;
    }
}
