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
 * The transporter company closes (completes) a waybill after delivery.
 *
 * RS API signature:
 *   int close_waybill_transporter(
 *       string   su, string sp,
 *       int      waybill_id,
 *       string   reception_info,
 *       string   receiver_info,
 *       DateTime delivery_date
 *   )
 *
 * params keys:
 *   waybill_id     — ID of the waybill
 *   reception_info — sender info (optional)
 *   receiver_info  — recipient info (optional)
 *   delivery_date  — delivery datetime (ISO 8601)
 *
 * Return codes:
 *    1   — closed successfully
 *   -1   — failed
 *  -100  — invalid credentials  → WaybillRequestException
 *  -101  — not your waybill     → WaybillRequestException
 */
class CloseWaybillTransporterRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::CLOSE_WAYBILL_TRANSPORTER;

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
                message:      'You are not the transporter of this waybill and cannot close it.',
                responseBody: $response->body(),
                code:         -101,
            );
        }

        return new BooleanDto(result: $result === 1);
    }
}
