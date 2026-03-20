<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\WaybillCreatedDto;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

class CreateWaybillTemplateRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::SAVE_WAYBILL_TEMPLATE;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): WaybillCreatedDto
    {
        $data = $response->xmlReader()->xpathValue('//RESULT')->sole();
        return new WaybillCreatedDto(
            id:     (int)    ($data['ID']             ?? 0),
            number: (string) ($data['WAYBILL_NUMBER'] ?? ''),
        );
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        return str_contains($response->body(), 'Server Error');
    }
}
