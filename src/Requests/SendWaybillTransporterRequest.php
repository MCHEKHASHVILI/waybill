<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Enums\WaybillErrorCode;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillRequestException;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

/**
 * The transporter company activates a waybill, specifying the
 * transportation start datetime. Returns the waybill number.
 *
 * RS API signature:
 *   int send_waybill_transporter(
 *       string   su, string sp,
 *       int      waybill_id,
 *       DateTime begin_date,
 *       out string waybill_number
 *   )
 *
 * params keys:
 *   waybill_id — ID of the waybill
 *   begin_date — transportation start datetime (ISO 8601)
 */
class SendWaybillTransporterRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::SEND_WAYBILL_TRANSPORTER;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): StringDto
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

        if ($result < 0) {
            throw new WaybillRequestException(
                message:      sprintf('RS send_waybill_transporter failed with code %d', $result),
                responseBody: $response->body(),
                code:         $result,
            );
        }

        // On success RS returns the waybill number in the out parameter;
        // xml-wrangler surfaces it as waybill_numberResult
        $number = (string) ($data['waybill_numberResult'] ?? '');

        return new StringDto(value: $number);
    }
}
