<?php

use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillCreatedDto;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillRequestException;
use Mchekhashvili\Rs\Waybill\Requests\UpdateWaybillRequest;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;

/**
 * UpdateWaybillRequest integration tests.
 *
 * These tests hit the live RS API and require credentials in .env.
 */
test('throws WaybillRequestException when attempting to update a deleted/cancelled waybill', function () {
    // Waybill 978941382 is permanently cancelled on the RS test environment.
    // save_waybill returns STATUS = -1029 ("cannot edit/delete cancelled waybill"),
    // which UpdateWaybillRequest now correctly surfaces as WaybillRequestException.
    $data = [
        'waybill' => [
            'WAYBILL' => [
                'ID'             => '978941382',
                'WAYBILL_NUMBER' => '',
                'SUB_WAYBILLS'   => [],
                'GOODS_LIST'     => [
                    ['GOODS' => [
                        'ID'         => '1',
                        'W_NAME'     => '\u10E4\u10D0\u10E0\u10D8 \u10E3\u10DC\u10D8\u10D5\u10D4\u10E0\u10E1\u10D0\u10DA\u10E3\u10E0\u10D8',
                        'UNIT_ID'    => '1',
                        'UNIT_TXT'   => '',
                        'QUANTITY'   => '2',
                        'PRICE'      => '10',
                        'AMOUNT'     => '20',
                        'BAR_CODE'   => '999908\u10EB',
                        'VAT_TYPE'   => '1',
                        'STATUS'     => '1',
                        'QUANTITY_F' => '0',
                    ]],
                ],
                'TYPE'            => '2',
                'BUYER_TIN'       => '12345678910',
                'CHEK_BUYER_TIN'  => '1',
                'BUYER_NAME'      => '\u10E8\u10DE\u10E1 \u10E0\u10D4\u10DB\u10DB\u10E8\u10D4\u10DC\u10D8',
                'START_ADDRESS'   => '\u10D0\u10D2\u10DA\u10D0\u10EB\u10D8\u10E1 \u10E5. 32',
                'END_ADDRESS'     => '\u10EF\u10D0\u10D5\u10D0\u10EE\u10D4\u10D7\u10D8\u10E1 \u10E5.12a',
                'DRIVER_TIN'      => '12345678910',
                'CHEK_DRIVER_TIN' => '1',
                'DRIVER_NAME'     => 'Revazi',
                'TRANSPORT_COAST' => '1000',
                'RECEPTION_INFO'  => '',
                'RECEIVER_INFO'   => '',
                'DELIVERY_DATE'   => '2025-11-11T18:13:59',
                'STATUS'          => '0',
                'SELER_UN_ID'     => '731937',
                'PAR_ID'          => '',
                'FULL_AMOUNT'     => '20',
                'CAR_NUMBER'      => 'ADA123',
                'S_USER_ID'       => 783,
                'BEGIN_DATE'      => '2025-11-10T18:13:59',
                'TRAN_COST_PAYER' => '2',
                'TRANS_ID'        => '1',
                'TRANS_TXT'       => '',
                'COMMENT'         => 'updated',
                'CATEGORY'        => '',
            ],
        ],
    ];

    expect(
        fn() => (new WaybillServiceConnector(...array_values(getServiceUserCredentials())))
            ->send(new UpdateWaybillRequest($data))
            ->dto()
    )->toThrow(WaybillRequestException::class);

})->skip(!hasCredentials(), 'RS_SERVICE_USERNAME / RS_SERVICE_PASSWORD not set in environment');
