<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class UpdateServiceUserRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::UPDATE_SERVICE_USER;
    protected AuthMethod $authMethod = AuthMethod::BOTH;
    public function __construct(protected mixed $params = []) {}
    public function createDtoFromResponse(Response $response): BooleanDto
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        return new BooleanDto(
            result: strtolower((string) $data["{$this->action->value}Result"]) === "true"
        );
    }
}
