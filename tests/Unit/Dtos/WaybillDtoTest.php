<?php

use Mchekhashvili\RsWaybill\Mappers\WaybillMapper;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;

/**
 * WaybillDto is a pure readonly value object with no logic of its own.
 * These tests verify it is correctly constructed via WaybillMapper::fromXmlArray(),
 * which is the only authorised way to build a WaybillDto from raw XML data.
 */
describe('WaybillDto construction via WaybillMapper', function () {

    test('produces a WaybillDto instance from minimal data', function () {
        $dto = WaybillMapper::fromXmlArray([
            'ID'             => '976627249',
            'WAYBILL_NUMBER' => 'WB-0001',
            'STATUS'         => '0',
            'GOODS_LIST'     => '',
        ]);

        expect($dto)->toBeInstanceOf(WaybillDto::class);
        expect($dto->id)->toBe(976627249);
        expect($dto->number)->toBe('WB-0001');
        expect($dto->status)->toBe(WaybillStatus::SAVED);
        expect($dto->goods_list)->toBe([]);
    });

    test('all nullable fields are null when data is empty', function () {
        $dto = WaybillMapper::fromXmlArray([
            'ID'             => '1',
            'WAYBILL_NUMBER' => '',
        ]);

        expect($dto->buyer_tin)->toBeNull();
        expect($dto->buyer_name)->toBeNull();
        expect($dto->status)->toBeNull();
        expect($dto->delivery_date)->toBeNull();
        expect($dto->category)->toBeNull();
        expect($dto->delivery_cost_payer)->toBeNull();
    });

    test('all readonly properties are immutable', function () {
        $dto = WaybillMapper::fromXmlArray(['ID' => '1', 'WAYBILL_NUMBER' => 'WB-X']);

        expect(fn() => $dto->id = 999)->toThrow(Error::class);
    });

});
