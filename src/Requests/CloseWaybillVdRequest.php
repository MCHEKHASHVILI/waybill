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
 * Closes (completes) a waybill and records the delivery date at the same time.
 *
 * RS API signature:
 *   int close_waybill_vd(string su, string sp, DateTime delivery_date, int waybill_id)
 *
 * Return codes:
 *    1   — closed successfully
 *   -1   — failed (generic)
 *  -100  — invalid service credentials  → WaybillRequestException
 *  -101  — not your waybill             → WaybillRequestException
 */
class CloseWaybillVdRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::CLOSE_WAYBILL_vd;

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
                message:      'You do not own this waybill and cannot close it.',
                responseBody: $response->body(),
                code:         -101,
            );
        }

        return new BooleanDto(result: $result === 1);
    }
}
