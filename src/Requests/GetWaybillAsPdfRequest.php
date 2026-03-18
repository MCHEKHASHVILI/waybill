<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\StringDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetWaybillAsPdfRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::GET_PRINT_PDF;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): StringDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        // The result is a base64-encoded PDF - must NOT be lowercased as base64 is case-sensitive
        return new StringDto(
            value: (string) $data["{$this->action->value}Result"],
        );
    }
}
