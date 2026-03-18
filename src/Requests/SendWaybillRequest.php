<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\StringDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

/**
 * Sends (activates) a saved waybill.
 *
 * On success the RS API returns the assigned waybill number as a string.
 */
class SendWaybillRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::SEND_WAYBILL;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): StringDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        return new StringDto(
            value: (string) $data["{$this->action->value}Result"]
        );
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return str_contains($response->body(), 'Server Error');
    }
}
