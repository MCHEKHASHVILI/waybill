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
            id:                   (int)    ($data['ID']              ?? 0),
            number:               (string) ($data['WAYBILL_NUMBER']  ?? ''),
            sub_waybills:         !empty($data['SUB_WAYBILLS'])  ? (array) $data['SUB_WAYBILLS']  : null,
            goods_list:           !empty($data['GOODS_LIST'])    ? ProductMapper::fromXmlCollection($data['GOODS_LIST']) : [],
            type_id:              isset($data['TYPE'])           && $data['TYPE'] !== ''            ? (int) $data['TYPE']            : null,
            buyer_tin:            isset($data['BUYER_TIN'])      && $data['BUYER_TIN'] !== ''       ? (string) $data['BUYER_TIN']    : null,
            buyer_is_resident:    isset($data['CHEK_BUYER_TIN']) && $data['CHEK_BUYER_TIN'] !== '' ? (bool)(int) $data['CHEK_BUYER_TIN'] : null,
            buyer_name:           isset($data['BUYER_NAME'])     && $data['BUYER_NAME'] !== ''      ? (string) $data['BUYER_NAME']   : null,
            address_from:         isset($data['START_ADDRESS'])  && $data['START_ADDRESS'] !== ''   ? (string) $data['START_ADDRESS'] : null,
            address_to:           isset($data['END_ADDRESS'])    && $data['END_ADDRESS'] !== ''     ? (string) $data['END_ADDRESS']  : null,
            driver_tin:           isset($data['DRIVER_TIN'])     && $data['DRIVER_TIN'] !== ''      ? (int) $data['DRIVER_TIN']      : null,
            driver_is_resident:   isset($data['CHEK_DRIVER_TIN']) && $data['CHEK_DRIVER_TIN'] !== '' ? (bool)(int) $data['CHEK_DRIVER_TIN'] : null,
            driver_name:          isset($data['DRIVER_NAME'])    && $data['DRIVER_NAME'] !== ''     ? (string) $data['DRIVER_NAME']  : null,
            delivery_cost:        isset($data['TRANSPORT_COAST']) && $data['TRANSPORT_COAST'] !== '' ? (float) $data['TRANSPORT_COAST'] : null,
            supplier_info:        isset($data['RECEPTION_INFO']) && $data['RECEPTION_INFO'] !== ''  ? (string) $data['RECEPTION_INFO'] : null,
            receiver_info:        isset($data['RECEIVER_INFO'])  && $data['RECEIVER_INFO'] !== ''   ? (string) $data['RECEIVER_INFO']  : null,
            delivery_date:        !empty($data['DELIVERY_DATE'])  ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data['DELIVERY_DATE']) ?: null : null,
            status:               isset($data['STATUS'])          && $data['STATUS'] !== ''          ? WaybillStatus::tryFrom((int) $data['STATUS'])      : null,
            seller_tenant_id:     isset($data['SELER_UN_ID'])    && $data['SELER_UN_ID'] !== ''     ? (int) $data['SELER_UN_ID']    : null,
            parent_id:            isset($data['PAR_ID'])         && $data['PAR_ID'] !== ''           ? (int) $data['PAR_ID']         : null,
            full_amount:          isset($data['FULL_AMOUNT'])    && $data['FULL_AMOUNT'] !== ''      ? (float) $data['FULL_AMOUNT']  : null,
            vehicle_state_number: isset($data['CAR_NUMBER'])     && $data['CAR_NUMBER'] !== ''       ? (string) $data['CAR_NUMBER']  : null,
            service_user_id:      isset($data['S_USER_ID'])      && $data['S_USER_ID'] !== ''        ? (int) $data['S_USER_ID']      : null,
            send_at:              !empty($data['BEGIN_DATE'])     ? DateTimeImmutable::createFromFormat("Y-m-d\TH:i:s", $data['BEGIN_DATE']) ?: null : null,
            delivery_cost_payer:  isset($data['TRAN_COST_PAYER']) && $data['TRAN_COST_PAYER'] !== '' ? DeliveryCostPayer::tryFrom((int) $data['TRAN_COST_PAYER']) : null,
            delivery_type_id:     isset($data['TRANS_ID'])       && $data['TRANS_ID'] !== ''         ? (int) $data['TRANS_ID']       : null,
            delivery_type_name:   isset($data['TRANS_TXT'])      && $data['TRANS_TXT'] !== ''        ? (string) $data['TRANS_TXT']   : null,
            comment:              isset($data['COMMENT'])        && $data['COMMENT'] !== ''           ? (string) $data['COMMENT']     : null,
            category:             isset($data['CATEGORY'])       && $data['CATEGORY'] !== ''          ? WaybillCategory::tryFrom((int) $data['CATEGORY'])   : null,
        );
    }

    /**
     * Serialise a WaybillDto back to the flat array the RS SOAP API expects.
     * Null / empty values are omitted so the API uses its own defaults.
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
}
