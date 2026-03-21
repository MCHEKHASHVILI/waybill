<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Primitives\BooleanDto;
use Mchekhashvili\Rs\Waybill\Enums\WaybillErrorCode;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillRequestException;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

/**
 * The transporter company fills in the driver and vehicle fields
 * on a waybill that was forwarded to them by the seller.
 *
 * RS API signature:
 *   int save_waybill_transporter(
 *       string su, string sp,
 *       int    waybill_id,
 *       string car_number,
 *       string driver_tin,
 *       int    chek_driver_tin,
 *       string driver_name,
 *       int    trans_id,
 *       string trans_txt,
 *       string reception_info,
 *       string receiver_info
 *   )
 *
 * params keys:
 *   waybill_id      — ID of the waybill forwarded to the transporter
 *   car_number      — vehicle plate number
 *   driver_tin      — driver personal ID number
 *   chek_driver_tin — 1 if Georgian citizen, 0 if foreign
 *   driver_name     — driver full name (required when foreign)
 *   trans_id        — transportation type ID
 *   trans_txt       — free-text transport description (required when trans_id = 4 / "other")
 *   reception_info  — sender info (optional)
 *   receiver_info   — recipient info (optional)
 */
class SaveWaybillTransporterRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::SAVE_WAYBILL_TRANSPORTER;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): BooleanDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        $result = (int) ($data["{$this->action->value}Result"] ?? -1);

        if ($result === -100) {
            throw new WaybillRequestException(
                message:      WaybillErrorCode::INVALID_SERVICE_USER_OR_PASSWORD->message(),
                responseBody: $response->body(),
                code:         -100,
            );
        }

        if ($result === -101) {
            throw new WaybillRequestException(
                message:      'You are not the transporter of this waybill.',
                responseBody: $response->body(),
                code:         -101,
            );
        }

        return new BooleanDto(result: $result === 1);
    }
}
