<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Enums\AuthMethod;
use Mchekhashvili\Rs\Waybill\Dtos\Primitives\StringDto;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

class GetNameFromTinRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action     $action     = Action::GET_NAME_FROM_TIN;
    protected AuthMethod $authMethod = AuthMethod::SERVICE_USER;

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
