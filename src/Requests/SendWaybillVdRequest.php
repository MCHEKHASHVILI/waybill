<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

/**
 * Activates a saved waybill with an explicit transportation start datetime.
 *
 * RS API signature:
 *   string send_waybill_vd(string su, string sp, DateTime begin_date, int waybill_id)
 *
 * Returns the waybill number assigned by RS on activation.
 *
 * Use this instead of SendWaybillRequest when you need to specify
 * a deferred or past activation datetime (e.g. deferred activation
 * up to 3 days in the future).
 */
class SendWaybillVdRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::SEND_WAYBILL_VD;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): StringDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );
        return new StringDto(value: (string) ($data["{$this->action->value}Result"] ?? ''));
    }
}
