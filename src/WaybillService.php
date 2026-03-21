<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill;

use DateTimeImmutable;
use DateTimeInterface;
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
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillConnectionException;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillRequestException;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillServerException;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillServiceException;
use Mchekhashvili\Rs\Waybill\Mappers\WaybillMapper;
use Mchekhashvili\Rs\Waybill\Requests\CloseWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\CloseWaybillTransporterRequest;
use Mchekhashvili\Rs\Waybill\Requests\CloseWaybillVdRequest;
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
use Mchekhashvili\Rs\Waybill\Requests\RejectWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\SaveWaybillTransporterRequest;
use Mchekhashvili\Rs\Waybill\Requests\SendWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\SendWaybillTransporterRequest;
use Mchekhashvili\Rs\Waybill\Requests\SendWaybillVdRequest;
use Mchekhashvili\Rs\Waybill\Requests\UpdateServiceUserRequest;
use Mchekhashvili\Rs\Waybill\Requests\UpdateWaybillRequest;
use Mchekhashvili\Rs\Waybill\Requests\WhatIsMyIpRequest;
use Saloon\Exceptions\Request\RequestException;

/**
 * WaybillService is the single entry point for the RS WaybillService API.
 *
 * It hides Saloon\'s connector/request/response mechanics and returns
 * typed domain objects directly. Callers never interact with Saloon.
 *
 * Every method can throw one of three SDK exceptions, all extending
 * WaybillServiceException so a single catch block suffices:
 *
 *   WaybillConnectionException — network/transport failure (timeout, DNS, etc.)
 *   WaybillServerException     — RS server returned an HTML error page
 *   WaybillRequestException    — RS API returned a business error or SOAP fault
 *
 * Usage:
 *   $service = new WaybillService(serviceUsername: 'su', servicePassword: 'sp');
 *
 *   try {
 *       $waybill = $service->getWaybill(id: 123);
 *   } catch (WaybillConnectionException $e) {
 *       // network unreachable, retry later
 *   } catch (WaybillServerException $e) {
 *       // RS server error, inspect $e->getResponseBody()
 *   } catch (WaybillRequestException $e) {
 *       // RS business or API error, inspect $e->getCode() / $e->getMessage()
 *   }
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

    /** @throws WaybillServiceException */
    public function getServerTime(): DateTimeImmutable
    {
        return $this->send(new GetServerTimeRequest())->dto()->value;
    }

    /** @throws WaybillServiceException */
    public function getMyIp(): string
    {
        return $this->send(new WhatIsMyIpRequest())->dto()->value;
    }

    // -------------------------------------------------------------------------
    // Waybill — reads
    // -------------------------------------------------------------------------

    /** @throws WaybillServiceException */
    public function getWaybill(int $id): WaybillDto
    {
        return $this->send(new GetWaybillRequest(['id' => $id]))->dto();
    }

    /** @throws WaybillServiceException */
    public function getWaybillByNumber(string $number): WaybillDto
    {
        return $this->send(new GetWaybillByNumberRequest(['waybill_number' => $number]))->dto();
    }

    /**
     * @return WaybillDto[]
     * @throws WaybillServiceException
     */
    public function getWaybills(array $params = []): array
    {
        return $this->send(new GetWaybillsRequest($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     * @throws WaybillServiceException
     */
    public function getWaybillsEx(array $params = []): array
    {
        return $this->send(new GetWaybillsExRequest($params))->dto()->data;
    }

    /**
     * Returns waybills updated within the given datetime range (max 3 days).
     *
     * Returns both sold and purchased waybills where the authenticated user
     * appears as either seller or buyer for the given company.
     *
     * @param DateTimeInterface $lastUpdateFrom start of the update datetime range
     * @param DateTimeInterface $lastUpdateTo   end of the update datetime range (max 3 days after start)
     * @param string|null       $buyerTin       optional — filter by buyer TIN
     *
     * @return WaybillDto[]
     * @throws WaybillServiceException
     * @throws \InvalidArgumentException if the date range exceeds 3 days
     */
    public function getWaybillsV1(
        DateTimeInterface $lastUpdateFrom,
        DateTimeInterface $lastUpdateTo,
        string|null       $buyerTin = null,
    ): array {
        $diffDays = (int) $lastUpdateFrom->diff(new DateTimeImmutable($lastUpdateTo->format('c')))->days;

        if ($diffDays > 3) {
            throw new \InvalidArgumentException(
                sprintf(
                    'getWaybillsV1 date range cannot exceed 3 days, got %d days (%s to %s).',
                    $diffDays,
                    $lastUpdateFrom->format('Y-m-d H:i:s'),
                    $lastUpdateTo->format('Y-m-d H:i:s'),
                )
            );
        }

        $params = [
            'last_update_date_s' => $lastUpdateFrom->format('Y-m-d\TH:i:s'),
            'last_update_date_e' => $lastUpdateTo->format('Y-m-d\TH:i:s'),
        ];

        if ($buyerTin !== null) {
            $params['buyer_tin'] = $buyerTin;
        }

        return $this->send(new GetWaybillsV1Request($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     * @throws WaybillServiceException
     */
    public function getWaybillsAsBuyer(array $params = []): array
    {
        return $this->send(new GetWaybillsAsBuyerRequest($params))->dto()->data;
    }

    /**
     * @return WaybillDto[]
     * @throws WaybillServiceException
     */
    public function getWaybillsAsBuyerEx(array $params = []): array
    {
        return $this->send(new GetWaybillsAsBuyerExRequest($params))->dto()->data;
    }

    /**
     * Returns the waybill as a base64-encoded PDF string.
     *
     * @throws WaybillServiceException
     */
    public function getWaybillAsPdf(int $waybillId): string
    {
        return $this->send(new GetWaybillAsPdfRequest(['waybill_id' => $waybillId]))->dto()->value;
    }

    /**
     * @return WaybillProductDto[]
     * @throws WaybillServiceException
     */
    public function getWaybillGoodsList(int $waybillId): array
    {
        return $this->send(new GetWaybillGoodsListRequest(['waybill_id' => $waybillId]))->dto()->data;
    }

    // -------------------------------------------------------------------------
    // Waybill — writes
    // -------------------------------------------------------------------------

    /** @throws WaybillServiceException */
    public function createWaybill(WaybillDto $waybill): WaybillCreatedDto
    {
        return $this->send(
            new CreateWaybillRequest(['waybill' => WaybillMapper::toParams($waybill)])
        )->dto();
    }

    /** @throws WaybillServiceException */
    public function updateWaybill(WaybillDto $waybill): WaybillCreatedDto
    {
        return $this->send(
            new UpdateWaybillRequest(['waybill' => WaybillMapper::toParams($waybill)])
        )->dto();
    }

    /**
     * Activates a saved waybill using the current datetime as the
     * transportation start. Returns the waybill number assigned by RS.
     *
     * @throws WaybillServiceException
     */
    public function sendWaybill(int $waybillId): string
    {
        return $this->send(new SendWaybillRequest(['waybill_id' => $waybillId]))->dto()->value;
    }

    /**
     * Activates a saved waybill with an explicit transportation start datetime.
     * Use this instead of sendWaybill() when you need deferred or past-dated
     * activation (RS allows up to 3 days in the future).
     *
     * Returns the waybill number assigned by RS.
     *
     * @throws WaybillServiceException
     */
    public function sendWaybillWithDate(int $waybillId, DateTimeInterface $beginDate): string
    {
        return $this->send(new SendWaybillVdRequest([
            'waybill_id' => $waybillId,
            'begin_date' => $beginDate->format('Y-m-d\TH:i:s'),
        ]))->dto()->value;
    }

    /** @throws WaybillServiceException */
    public function confirmWaybill(int $waybillId): bool
    {
        return $this->send(new ConfirmWaybillRequest(['waybill_id' => $waybillId]))->dto()->result;
    }

    /**
     * Closes (completes) a waybill. Throws WaybillRequestException with
     * code -100 for bad credentials or -101 if the waybill is not yours.
     *
     * @throws WaybillServiceException
     */
    public function closeWaybill(int $waybillId): bool
    {
        return $this->send(new CloseWaybillRequest(['waybill_id' => $waybillId]))->dto()->result;
    }

    /**
     * Closes (completes) a waybill and records the delivery date at the same time.
     * Throws WaybillRequestException with code -100/-101 for auth/ownership errors.
     *
     * @throws WaybillServiceException
     */
    public function closeWaybillWithDate(int $waybillId, DateTimeInterface $deliveryDate): bool
    {
        return $this->send(new CloseWaybillVdRequest([
            'waybill_id'    => $waybillId,
            'delivery_date' => $deliveryDate->format('Y-m-d\TH:i:s'),
        ]))->dto()->result;
    }

    /**
     * Deletes a saved waybill. Throws WaybillRequestException with
     * code -100 for bad credentials or -101 if the waybill is not yours.
     *
     * @throws WaybillServiceException
     */
    public function deleteWaybill(int $waybillId): bool
    {
        return $this->send(new DeleteWaybillRequest(['waybill_id' => $waybillId]))->dto()->result;
    }

    /**
     * Allows a buyer to reject a waybill addressed to them.
     *
     * @throws WaybillServiceException
     */
    public function rejectWaybill(int $waybillId): bool
    {
        return $this->send(new RejectWaybillRequest(['waybill_id' => $waybillId]))->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Transporter workflow
    // -------------------------------------------------------------------------

    /**
     * The transporter company fills in the driver/vehicle fields on a waybill
     * forwarded to them by the seller.
     *
     * @throws WaybillServiceException
     */
    public function saveWaybillAsTransporter(
        int         $waybillId,
        string      $carNumber,
        string      $driverTin,
        int         $checkDriverTin,
        string      $driverName,
        int         $transId,
        string      $transTxt      = '',
        string      $receptionInfo = '',
        string      $receiverInfo  = '',
    ): bool {
        return $this->send(new SaveWaybillTransporterRequest([
            'waybill_id'      => $waybillId,
            'car_number'      => $carNumber,
            'driver_tin'      => $driverTin,
            'chek_driver_tin' => $checkDriverTin,
            'driver_name'     => $driverName,
            'trans_id'        => $transId,
            'trans_txt'       => $transTxt,
            'reception_info'  => $receptionInfo,
            'receiver_info'   => $receiverInfo,
        ]))->dto()->result;
    }

    /**
     * The transporter company activates a waybill with an explicit
     * transportation start datetime. Returns the assigned waybill number.
     *
     * @throws WaybillServiceException
     */
    public function sendWaybillAsTransporter(int $waybillId, DateTimeInterface $beginDate): string
    {
        return $this->send(new SendWaybillTransporterRequest([
            'waybill_id' => $waybillId,
            'begin_date' => $beginDate->format('Y-m-d\TH:i:s'),
        ]))->dto()->value;
    }

    /**
     * The transporter company closes (completes) a waybill after delivery.
     *
     * @throws WaybillServiceException
     */
    public function closeWaybillAsTransporter(
        int               $waybillId,
        DateTimeInterface $deliveryDate,
        string            $receptionInfo = '',
        string            $receiverInfo  = '',
    ): bool {
        return $this->send(new CloseWaybillTransporterRequest([
            'waybill_id'    => $waybillId,
            'reception_info'=> $receptionInfo,
            'receiver_info' => $receiverInfo,
            'delivery_date' => $deliveryDate->format('Y-m-d\TH:i:s'),
        ]))->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Waybill templates
    // -------------------------------------------------------------------------

    /** @throws WaybillServiceException */
    public function createWaybillTemplate(WaybillDto $waybill): WaybillCreatedDto
    {
        return $this->send(
            new CreateWaybillTemplateRequest(['waybill' => WaybillMapper::toParams($waybill)])
        )->dto();
    }

    /** @throws WaybillServiceException */
    public function deleteWaybillTemplate(int $templateId): bool
    {
        return $this->send(new DeleteWaybillTemplateRequest(['waybill_id' => $templateId]))->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Barcodes
    // -------------------------------------------------------------------------

    /**
     * @return BarcodeDto[]
     * @throws WaybillServiceException
     */
    public function getBarcodes(array $params = []): array
    {
        return $this->send(new GetBarcodesRequest($params))->dto()->data;
    }

    /** @throws WaybillServiceException */
    public function createBarcode(string $barCode, string $goodsName, int $unitId): bool
    {
        return $this->send(new CreateBarcodeRequest([
            'bar_code'   => $barCode,
            'goods_name' => $goodsName,
            'unit_id'    => $unitId,
        ]))->dto()->result;
    }

    /** @throws WaybillServiceException */
    public function deleteBarcode(string $barCode): bool
    {
        return $this->send(new DeleteBarcodeRequest(['bar_code' => $barCode]))->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Vehicles
    // -------------------------------------------------------------------------

    /**
     * @return VehicleDto[]
     * @throws WaybillServiceException
     */
    public function getVehicleStateNumbers(): array
    {
        return $this->send(new GetVehicleStateNumbersRequest())->dto()->data;
    }

    /** @throws WaybillServiceException */
    public function createVehicleStateNumber(string $stateNumber): bool
    {
        return $this->send(
            new CreateVehicleStateNumberRequest(['car_number' => $stateNumber])
        )->dto()->result;
    }

    /** @throws WaybillServiceException */
    public function deleteVehicleStateNumber(string $stateNumber): bool
    {
        return $this->send(
            new DeleteVehicleStateNumberRequest(['car_number' => $stateNumber])
        )->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Reference data
    // -------------------------------------------------------------------------

    /**
     * @return ExciseCodeDto[]
     * @throws WaybillServiceException
     */
    public function getExciseCodes(string $searchText = ''): array
    {
        $params = $searchText !== '' ? ['s_text' => $searchText] : [];
        return $this->send(new GetExciseCodesRequest($params))->dto()->data;
    }

    /**
     * @return WaybillTypeDto[]
     * @throws WaybillServiceException
     */
    public function getWaybillTypes(): array
    {
        return $this->send(new GetWaybillTypesRequest())->dto()->data;
    }

    /**
     * @return WaybillUnitDto[]
     * @throws WaybillServiceException
     */
    public function getWaybillUnits(): array
    {
        return $this->send(new GetWaybillUnitsRequest())->dto()->data;
    }

    /**
     * @return TransportationTypeDto[]
     * @throws WaybillServiceException
     */
    public function getTransportationTypes(): array
    {
        return $this->send(new GetTransportationTypesRequest())->dto()->data;
    }

    /**
     * @return WoodTypeDto[]
     * @throws WaybillServiceException
     */
    public function getWoodTypes(): array
    {
        return $this->send(new GetWoodTypesRequest())->dto()->data;
    }

    /**
     * @return ErrorCodeDto[]
     * @throws WaybillServiceException
     */
    public function getErrorCodes(): array
    {
        return $this->send(new GetErrorCodesRequest())->dto()->data;
    }

    // -------------------------------------------------------------------------
    // Contragent / TIN lookups
    // -------------------------------------------------------------------------

    /** @throws WaybillServiceException */
    public function getNameFromTin(string $tin): string
    {
        return $this->send(new GetNameFromTinRequest(['tin' => $tin]))->dto()->value;
    }

    /** @throws WaybillServiceException */
    public function getTinFromUnId(int $unId): ContragentDto
    {
        return $this->send(new GetTinFromUnIdRequest(['un_id' => $unId]))->dto();
    }

    /** @throws WaybillServiceException */
    public function getPayerTypeFromUnId(int $unId): string
    {
        return $this->send(new GetPayerTypeFromUnIdRequest(['un_id' => $unId]))->dto()->value;
    }

    /** @throws WaybillServiceException */
    public function isVatPayer(int $unId): bool
    {
        return $this->send(new IsVatPayerRequest(['un_id' => $unId]))->dto()->result;
    }

    /** @throws WaybillServiceException */
    public function isVatPayerByTin(string $tin): bool
    {
        return $this->send(new IsVatPayerTinRequest(['tin' => $tin]))->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Service users (tenant-level operations)
    // -------------------------------------------------------------------------

    /**
     * @return ServiceUserDto[]
     * @throws WaybillServiceException
     */
    public function getServiceUsers(): array
    {
        return $this->send(new GetServiceUsersRequest())->dto()->data;
    }

    /** @throws WaybillServiceException */
    public function updateServiceUser(array $params): bool
    {
        return $this->send(new UpdateServiceUserRequest($params))->dto()->result;
    }

    // -------------------------------------------------------------------------
    // Internal
    // -------------------------------------------------------------------------

    /**
     * Executes a request through the connector and translates any Saloon
     * RequestException (HTTP 4xx/5xx) into WaybillRequestException.
     *
     * Network failures are already converted to WaybillConnectionException
     * by WaybillServiceConnector::handleSendException().
     *
     * HTML error pages are caught by BaseRequest::hasRequestFailed() and
     * thrown as WaybillServerException before this method returns.
     *
     * @throws WaybillConnectionException on network/transport failure
     * @throws WaybillServerException     on RS HTML error page
     * @throws WaybillRequestException    on HTTP 4xx/5xx or SOAP fault
     */
    private function send(\Saloon\Http\Request $request): \Saloon\Http\Response
    {
        try {
            return $this->connector->send($request);
        } catch (WaybillServiceException $e) {
            // Already one of our exceptions (Connection or Server) — let it propagate
            throw $e;
        } catch (RequestException $e) {
            throw new WaybillRequestException(
                message:      'RS WaybillService API error: ' . $e->getMessage(),
                responseBody: $e->getResponse()->body(),
                code:         $e->getResponse()->status(),
                previous:     $e,
            );
        }
    }
}
