<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\Static\WaybillCreatedDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

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
