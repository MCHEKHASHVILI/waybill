<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\StringDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class WhatIsMyIpRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::WHAT_IS_MY_IP;
    protected AuthMethod $authMethod = AuthMethod::GUEST;
    public function __construct(protected mixed $params = []) {}
    public function createDtoFromResponse(Response $response): StringDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        return new StringDto(
            value: (string) strtolower((string) $data["{$this->action->value}Result"]),
        );
    }
}
