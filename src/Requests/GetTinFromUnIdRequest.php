<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Dtos\Static\ContragentDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class GetTinFromUnIdRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action     $action     = Action::GET_TIN_FROM_UN_ID;
    protected AuthMethod $authMethod = AuthMethod::SERVICE_USER;

    public function __construct(protected mixed $params = []) {}

    public function createDtoFromResponse(Response $response): ContragentDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        return new ContragentDto(
            un_id: (int)    ($data['un_id']                          ?? 0),
            tin:   (string) ($data["{$this->action->value}Result"]  ?? ''),
            name:  (string) ($data['name']                           ?? ''),
        );
    }
}
