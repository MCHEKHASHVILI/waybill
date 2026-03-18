<?php

use Mchekhashvili\RsWaybill\Mappers\WaybillMapper;
use Mchekhashvili\RsWaybill\Mappers\ProductMapper;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillDto;
use Mchekhashvili\RsWaybill\Dtos\Static\ProductDto;
use Mchekhashvili\RsWaybill\Enums\WaybillStatus;
use Mchekhashvili\RsWaybill\Enums\WaybillCategory;
use Mchekhashvili\RsWaybill\Enums\DeliveryCostPayer;

describe('WaybillMapper::fromXmlArray', function () {

    test('maps all scalar fields correctly', function () {
        $dto = WaybillMapper::fromXmlArray([
            'ID'             => '99',
            'WAYBILL_NUMBER' => 'WB-001',
            'BUYER_TIN'      => '12345678910',
            'BUYER_NAME'     => 'Test Company',
            'START_ADDRESS'  => 'Address A',
            'END_ADDRESS'    => 'Address B',
            'TRANSPORT_COAST'=> '100.5',
            'FULL_AMOUNT'    => '500.0',
            'CAR_NUMBER'     => 'ABC123',
            'S_USER_ID'      => '783',
            'TRANS_ID'       => '1',
            'TRANS_TXT'      => 'Car',
            'COMMENT'        => 'test comment',
            'SELER_UN_ID'    => '731937',
        ]);

        expect($dto)->toBeInstanceOf(WaybillDto::class);
        expect($dto->id)->toBe(99);
        expect($dto->number)->toBe('WB-001');
        expect($dto->buyer_tin)->toBe('12345678910');
        expect($dto->buyer_name)->toBe('Test Company');
        expect($dto->delivery_cost)->toBe(100.5);
        expect($dto->full_amount)->toBe(500.0);
        expect($dto->vehicle_state_number)->toBe('ABC123');
        expect($dto->service_user_id)->toBe(783);
        expect($dto->comment)->toBe('test comment');
        expect($dto->seller_tenant_id)->toBe(731937);
    });

    test('maps WaybillStatus enum correctly', function () {
        $dto = WaybillMapper::fromXmlArray(['ID' => '1', 'WAYBILL_NUMBER' => '', 'STATUS' => '1']);
        expect($dto->status)->toBe(WaybillStatus::ACTIVE);
    });

    test('maps WaybillCategory enum correctly', function () {
        $dto = WaybillMapper::fromXmlArray(['ID' => '1', 'WAYBILL_NUMBER' => '', 'CATEGORY' => '1']);
        expect($dto->category)->toBe(WaybillCategory::WOOD);
    });

    test('maps DeliveryCostPayer enum correctly', function () {
        $dto = WaybillMapper::fromXmlArray(['ID' => '1', 'WAYBILL_NUMBER' => '', 'TRAN_COST_PAYER' => '1']);
        expect($dto->delivery_cost_payer)->toBe(DeliveryCostPayer::BUYER);
    });

    test('maps delivery_date as DateTimeImmutable', function () {
        $dto = WaybillMapper::fromXmlArray([
            'ID'            => '1',
            'WAYBILL_NUMBER'=> '',
            'DELIVERY_DATE' => '2024-03-15T10:30:00',
        ]);
        expect($dto->delivery_date)->toBeInstanceOf(DateTimeImmutable::class);
        expect($dto->delivery_date->format('Y-m-d'))->toBe('2024-03-15');
    });

    test('returns null for empty/missing optional fields', function () {
        $dto = WaybillMapper::fromXmlArray(['ID' => '1', 'WAYBILL_NUMBER' => '']);
        expect($dto->buyer_tin)->toBeNull();
        expect($dto->status)->toBeNull();
        expect($dto->delivery_date)->toBeNull();
        expect($dto->category)->toBeNull();
        expect($dto->goods_list)->toBe([]);
    });

    test('returns null for fields set to empty string', function () {
        $dto = WaybillMapper::fromXmlArray([
            'ID'            => '1',
            'WAYBILL_NUMBER'=> '',
            'BUYER_TIN'     => '',
            'STATUS'        => '',
            'CATEGORY'      => '',
        ]);
        expect($dto->buyer_tin)->toBeNull();
        expect($dto->status)->toBeNull();
        expect($dto->category)->toBeNull();
    });

});

describe('WaybillMapper::toParams', function () {

    test('round-trips a WaybillDto back to params array', function () {
        $original = WaybillMapper::fromXmlArray([
            'ID'             => '42',
            'WAYBILL_NUMBER' => 'WB-042',
            'BUYER_TIN'      => '99999999999',
            'STATUS'         => '1',
            'TRAN_COST_PAYER'=> '2',
        ]);

        $params = WaybillMapper::toParams($original);

        expect($params['ID'])->toBe(42);
        expect($params['WAYBILL_NUMBER'])->toBe('WB-042');
        expect($params['BUYER_TIN'])->toBe('99999999999');
        expect($params['STATUS'])->toBe(WaybillStatus::ACTIVE->value);
        expect($params['TRAN_COST_PAYER'])->toBe(DeliveryCostPayer::SELLER->value);
    });

    test('omits null fields from params', function () {
        $dto    = WaybillMapper::fromXmlArray(['ID' => '1', 'WAYBILL_NUMBER' => '']);
        $params = WaybillMapper::toParams($dto);

        expect($params)->not->toHaveKey('BUYER_TIN');
        expect($params)->not->toHaveKey('STATUS');
        expect($params)->not->toHaveKey('CATEGORY');
    });

});

describe('ProductMapper::fromXmlCollection', function () {

    test('maps a list of products', function () {
        $products = ProductMapper::fromXmlCollection([
            ['ID' => '1', 'W_NAME' => 'Item A', 'UNIT_ID' => '1', 'QUANTITY' => '2', 'PRICE' => '10', 'AMOUNT' => '20', 'BAR_CODE' => 'BC1', 'VAT_TYPE' => '1', 'STATUS' => '1'],
            ['ID' => '2', 'W_NAME' => 'Item B', 'UNIT_ID' => '2', 'QUANTITY' => '3', 'PRICE' => '5',  'AMOUNT' => '15', 'BAR_CODE' => 'BC2', 'VAT_TYPE' => '1', 'STATUS' => '1'],
        ]);

        expect($products)->toHaveCount(2);
        expect($products[0])->toBeInstanceOf(ProductDto::class);
        expect($products[0]->name)->toBe('Item A');
        expect($products[1]->name)->toBe('Item B');
    });

    test('handles single product (assoc array, not a list)', function () {
        $products = ProductMapper::fromXmlCollection([
            'ID' => '1', 'W_NAME' => 'Solo Item', 'UNIT_ID' => '1',
            'QUANTITY' => '1', 'PRICE' => '10', 'AMOUNT' => '10',
            'BAR_CODE' => 'BC1', 'VAT_TYPE' => '1', 'STATUS' => '1',
        ]);

        expect($products)->toHaveCount(1);
        expect($products[0]->name)->toBe('Solo Item');
    });

    test('returns empty array for empty input', function () {
        expect(ProductMapper::fromXmlCollection([]))->toBe([]);
        expect(ProductMapper::fromXmlCollection(null))->toBe([]);
    });

    test('handles GOODS nested wrapper', function () {
        $products = ProductMapper::fromXmlCollection([
            'GOODS' => [
                'ID' => '5', 'W_NAME' => 'Nested Item', 'UNIT_ID' => '1',
                'QUANTITY' => '1', 'PRICE' => '10', 'AMOUNT' => '10',
                'BAR_CODE' => 'BC5', 'VAT_TYPE' => '1', 'STATUS' => '1',
            ],
        ]);

        expect($products)->toHaveCount(1);
        expect($products[0]->name)->toBe('Nested Item');
    });

});
