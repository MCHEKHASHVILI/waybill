<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Mappers;

use DateTimeImmutable;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillProductDto;
use Mchekhashvili\Rs\Waybill\Enums\WaybillStatus;
use Mchekhashvili\Rs\Waybill\Enums\DeliveryCostPayer;

final class WaybillProductMapper
{
    public static function fromXmlArray(array $data): WaybillProductDto
    {
        return new WaybillProductDto(
            id:                   (int)    ($data['ID']              ?? 0),
            waybill_number:       (string) ($data['WAYBILL_NUMBER']  ?? ''),
            name:                 (string) ($data['W_NAME']          ?? ''),
            unit_id:              (int)    ($data['UNIT_ID']         ?? 0),
            quantity:             (float)  ($data['QUANTITY']        ?? 0),
            price:                (float)  ($data['PRICE']           ?? 0),
            amount:               (float)  ($data['AMOUNT']          ?? 0),
            barcode:              (string) ($data['BAR_CODE']        ?? ''),
            is_confirmed:         (bool)(int) ($data['IS_CONFIRMED'] ?? 0),
            type_id:              isset($data['TYPE'])           && $data['TYPE'] !== ''             ? (int) $data['TYPE']              : null,
            buyer_tin:            isset($data['TIN'])            && $data['TIN'] !== ''              ? (string) $data['TIN']            : null,
            buyer_name:           isset($data['BUYER_NAME'])     && $data['BUYER_NAME'] !== ''       ? (string) $data['BUYER_NAME']     : null,
            address_from:         isset($data['START_ADDRESS'])  && $data['START_ADDRESS'] !== ''    ? (string) $data['START_ADDRESS']  : null,
            address_to:           isset($data['END_ADDRESS'])    && $data['END_ADDRESS'] !== ''      ? (string) $data['END_ADDRESS']    : null,
            driver_tin:           isset($data['DRIVER_TIN'])     && $data['DRIVER_TIN'] !== ''       ? (int) $data['DRIVER_TIN']        : null,
            driver_name:          isset($data['DRIVER_NAME'])    && $data['DRIVER_NAME'] !== ''      ? (string) $data['DRIVER_NAME']    : null,
            delivery_cost:        isset($data['TRANSPORT_COAST']) && $data['TRANSPORT_COAST'] !== '' ? (float) $data['TRANSPORT_COAST'] : null,
            supplier_info:        isset($data['RECEPTION_INFO']) && $data['RECEPTION_INFO'] !== ''   ? (string) $data['RECEPTION_INFO'] : null,
            receiver_info:        isset($data['RECEIVER_INFO'])  && $data['RECEIVER_INFO'] !== ''    ? (string) $data['RECEIVER_INFO']  : null,
            full_amount:          isset($data['FULL_AMOUNT'])    && $data['FULL_AMOUNT'] !== ''       ? (float) $data['FULL_AMOUNT']     : null,
            vehicle_state_number: isset($data['CAR_NUMBER'])     && $data['CAR_NUMBER'] !== ''        ? (string) $data['CAR_NUMBER']     : null,
            delivery_cost_payer:  isset($data['TRAN_COST_PAYER']) && $data['TRAN_COST_PAYER'] !== '' ? DeliveryCostPayer::tryFrom((int) $data['TRAN_COST_PAYER']) : null,
            delivery_type_id:     isset($data['TRANS_ID'])       && $data['TRANS_ID'] !== ''          ? (int) $data['TRANS_ID']          : null,
            status:               isset($data['STATUS'])         && $data['STATUS'] !== ''            ? WaybillStatus::tryFrom((int) $data['STATUS'])     : null,
            created_at:           !empty($data['CREATE_DATE'])   ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data['CREATE_DATE'])   ?: null : null,
            activated_at:         !empty($data['ACTIVATE_DATE']) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data['ACTIVATE_DATE']) ?: null : null,
            delivery_date:        !empty($data['DELIVERY_DATE']) ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data['DELIVERY_DATE']) ?: null : null,
            closed_at:            !empty($data['CLOSE_DATE'])    ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data['CLOSE_DATE'])    ?: null : null,
        );
    }
}
