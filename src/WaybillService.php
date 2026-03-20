<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill;

use DateTimeImmutable;
use Mchekhashvili\Rs\Waybill\Connectors\WaybillServiceConnector;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\BarcodeDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ContragentDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ErrorCodeDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ExciseCodeDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\ServiceUserDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\TransportationTypeDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\VehicleDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillCreatedDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillProductDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillTypeDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillUnitDto;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WoodTypeDto;
use Mchekhashvili\Rs\Waybill\Mappers\WaybillMapper;
use Mchekhashvili\Rs\Waybill\Requests\CloseWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\ConfirmWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\CreateBarcodeRequest;
use Mchekhashvili\Rs\Waybill\Requests\CreateVehicleStateNumberRequest;
use Mchekhashvili\Rs\Waybill\Requests\CreateWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\CreateWaybillTemplateRequest;
use Mchekhashvili\Rs\Waybill\Requests\DeleteBarcodeRequest;
use Mchekhashvili\Rs\Waybill\Requests\DeleteVehicleStateNumberRequest;
use Mchekhashvili\Rs\Waybill\Requests\DeleteWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\DeleteWaybillTemplateRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetBarcodesRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetErrorCodesRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetExciseCodesRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetNameFromTinRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetPayerTypeFromUnIdRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetServerTimeRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetServiceUsersRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetTinFromUnIdRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetTransportationTypesRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetVehicleStateNumbersRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillAsPdfRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillByNumberRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillGoodsListRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillTypesRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillUnitsRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsAsBuyerExRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsAsBuyerRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsExRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsRequest;
use Mchekhashvili\Rs\Waybill\Requests\GetWaybillsV1Request;
use Mchekhashvili\Rs\Waybill\Requests\GetWoodTypesRequest;
use Mchekhashvili\Rs\Waybill\Requests\IsVatPayerRequest;
use Mchekhashvili\Rs\Waybill\Requests\IsVatPayerTinRequest;
use Mchekhashvili\Rs\Waybill\Requests\SendWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\UpdateServiceUserRequest;
use Mchekhashvili\Rs\Waybill\Requests\UpdateWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\WhatIsMyIpRequest;

/**
 * WaybillService is the single entry point for the RS WaybillService API.
 *
 * It hides Saloon's connector/request/response mechanics and returns
 * typed domain objects directly. Callers never interact with Saloon.
 *
 * Usage:
 *   $service = new WaybillService(serviceUsername: 'su', servicePassword: 'sp');
 *   $waybill = $service->getWaybill(id: 123);
 *   $list    = $service->getWaybills(dateFrom: '2024-01-01', dateTo: '2024-01-31');
 *   $created = $service->createWaybill($waybillDto);
 *
 * When combined into the parent RS SDK:
 *   $rs->waybill()->getWaybill(id: 123);
 */
class WaybillService
{
    private WaybillServiceConnector $connector;

    public function __construct(
        string|null $serviceUsername = null,
        string|null $servicePassword = null,
        string|null $tenantUsername  = null,
        string|null $tenantPassword  = null,
    ) {
        $this->connector = new WaybillServiceConnector(
            service_username: $serviceUsername,
            service_password: $servicePassword,
            tenant_username:  $tenantUsername,
            tenant_password:  $tenantPassword,
        );
    }

    // -------------------------------------------------------------------------
    // Server / utility
    // -------------------------------------------------------------------------

    public function getServerTime(): DateTimeImmutable
    {
        return $this->connector->send(new GetServerTimeRequest())->dto()->value;
    }

    public function getMyIp(): string
    {
        return $this->connector->send(new WhatIsMyIpRequest())->dto()->value;
    }

    // -------------------------------------------------------------------------
    // Waybill — reads
    // -------------------------------------------------------------------------

    public function getWaybill(int $id): WaybillDto
    {
        return $this->connector->send(
            new GetWaybillRequest(['id' => $id])
        )->dto();
    }

    public function getWaybillByNumber(string $number): WaybillDto
    {
        return $this->connector->send(
            new GetWaybillByNumberRequest(['waybill_number' => $number])
        )->dto();
    }

    /**
     * @return WaybillDto[]
     */
    public function getWaybills(array $params = []): array
    {
        return $this->connector->send(new GetWaybillsRequest($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     */
    public function getWaybillsEx(array $params = []): array
    {
        return $this->connector->send(new GetWaybillsExRequest($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     */
    public function getWaybillsV1(array $params = []): array
    {
        return $this->connector->send(new GetWaybillsV1Request($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     */
    public function getWaybillsAsBuyer(array $params = []): array
    {
        return $this->connector->send(new GetWaybillsAsBuyerRequest($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     */
    public function getWaybillsAsBuyerEx(array $params = []): array
    {
        return $this->connector->send(new GetWaybillsAsBuyerExRequest($params))->dto()->data;
    }

    public function getWaybillAsPdf(int $waybillId): string
    {
        return $this->connector->send(
            new GetWaybillAsPdfRequest(['waybill_id' => $waybillId])
        )->dto()->value;
    }

    /**
     * @return WaybillProductDto[]
     */
    public function getWaybillGoodsList(int $waybillId): array
    {
        return $this->connector->send(
            new GetWaybillGoodsListRequest(['waybill_id' => $waybillId])
        )->dto()->data;
    }

    // -------------------------------------------------------------------------
    // Waybill — writes
    // -------------------------------------------------------------------------

    public function createWaybill(WaybillDto $waybill): WaybillCreatedDto
    {
        return $this->connector->send(
            new CreateWaybillRequest(['waybill' => WaybillMapper::toParams($waybill)])
        )->dto();
    }

    public function updateWaybill(WaybillDto $waybill): WaybillCreatedDto
    {
        return $this->connector->send(
            new UpdateWaybillRequest(['waybill' => WaybillMapper::toParams($waybill)])
        )->dto();
    }

    public function sendWaybill(int $waybillId): string
    {
        return $this->connector->send(
            new SendWaybillRequest(['waybill_id' => $waybillId])
        )->dto()->value;
    }

    public function confirmWaybill(int $waybillId): bool
    {
        return $this->connector->send(
            new ConfirmWaybillRequest(['waybill_id' => $waybillId])
        )->dto()->result;
    }

    public function closeWaybill(int $waybillId): bool
    {
        return $this->connector->send(
            new CloseWaybillRequest(['waybill_id' => $waybillId])
        )->dto()->result;
    }

    public function deleteWaybill(int $waybillId): bool
    {
        return $this->connector->send(
            new DeleteWaybillRequest(['waybill_id' => $waybillId])
        )->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Waybill templates
    // -------------------------------------------------------------------------

    public function createWaybillTemplate(WaybillDto $waybill): WaybillCreatedDto
    {
        return $this->connector->send(
            new CreateWaybillTemplateRequest(['waybill' => WaybillMapper::toParams($waybill)])
        )->dto();
    }

    public function deleteWaybillTemplate(int $templateId): bool
    {
        return $this->connector->send(
            new DeleteWaybillTemplateRequest(['waybill_id' => $templateId])
        )->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Barcodes
    // -------------------------------------------------------------------------

    /**
     * @return BarcodeDto[]
     */
    public function getBarcodes(array $params = []): array
    {
        return $this->connector->send(new GetBarcodesRequest($params))->dto()->data;
    }

    public function createBarcode(string $barCode, string $goodsName, int $unitId): bool
    {
        return $this->connector->send(new CreateBarcodeRequest([
            'bar_code'   => $barCode,
            'goods_name' => $goodsName,
            'unit_id'    => $unitId,
        ]))->dto()->result;
    }

    public function deleteBarcode(string $barCode): bool
    {
        return $this->connector->send(
            new DeleteBarcodeRequest(['bar_code' => $barCode])
        )->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Vehicles
    // -------------------------------------------------------------------------

    /**
     * @return VehicleDto[]
     */
    public function getVehicleStateNumbers(): array
    {
        return $this->connector->send(new GetVehicleStateNumbersRequest())->dto()->data;
    }

    public function createVehicleStateNumber(string $stateNumber): bool
    {
        return $this->connector->send(
            new CreateVehicleStateNumberRequest(['car_number' => $stateNumber])
        )->dto()->result;
    }

    public function deleteVehicleStateNumber(string $stateNumber): bool
    {
        return $this->connector->send(
            new DeleteVehicleStateNumberRequest(['car_number' => $stateNumber])
        )->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Reference data
    // -------------------------------------------------------------------------

    /**
     * @return ExciseCodeDto[]
     */
    public function getExciseCodes(string $searchText = ''): array
    {
        $params = $searchText !== '' ? ['s_text' => $searchText] : [];
        return $this->connector->send(new GetExciseCodesRequest($params))->dto()->data;
    }

    /**
     * @return WaybillTypeDto[]
     */
    public function getWaybillTypes(): array
    {
        return $this->connector->send(new GetWaybillTypesRequest())->dto()->data;
    }

    /**
     * @return WaybillUnitDto[]
     */
    public function getWaybillUnits(): array
    {
        return $this->connector->send(new GetWaybillUnitsRequest())->dto()->data;
    }

    /**
     * @return TransportationTypeDto[]
     */
    public function getTransportationTypes(): array
    {
        return $this->connector->send(new GetTransportationTypesRequest())->dto()->data;
    }

    /**
     * @return WoodTypeDto[]
     */
    public function getWoodTypes(): array
    {
        return $this->connector->send(new GetWoodTypesRequest())->dto()->data;
    }

    /**
     * @return ErrorCodeDto[]
     */
    public function getErrorCodes(): array
    {
        return $this->connector->send(new GetErrorCodesRequest())->dto()->data;
    }

    // -------------------------------------------------------------------------
    // Contragent / TIN lookups
    // -------------------------------------------------------------------------

    public function getNameFromTin(string $tin): string
    {
        return $this->connector->send(
            new GetNameFromTinRequest(['tin' => $tin])
        )->dto()->value;
    }

    public function getTinFromUnId(int $unId): ContragentDto
    {
        return $this->connector->send(
            new GetTinFromUnIdRequest(['un_id' => $unId])
        )->dto();
    }

    public function getPayerTypeFromUnId(int $unId): string
    {
        return $this->connector->send(
            new GetPayerTypeFromUnIdRequest(['un_id' => $unId])
        )->dto()->value;
    }

    public function isVatPayer(int $unId): bool
    {
        return $this->connector->send(
            new IsVatPayerRequest(['un_id' => $unId])
        )->dto()->result;
    }

    public function isVatPayerByTin(string $tin): bool
    {
        return $this->connector->send(
            new IsVatPayerTinRequest(['tin' => $tin])
        )->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Service users (tenant-level operations)
    // -------------------------------------------------------------------------

    /**
     * @return ServiceUserDto[]
     */
    public function getServiceUsers(): array
    {
        return $this->connector->send(new GetServiceUsersRequest())->dto()->data;
    }

    public function updateServiceUser(array $params): bool
    {
        return $this->connector->send(
            new UpdateServiceUserRequest($params)
        )->dto()->result;
    }
}
