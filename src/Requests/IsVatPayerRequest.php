<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Mchekhashvili\RsWaybill\Dtos\InBuilt\BooleanDto;
use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class IsVatPayerRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::IS_VAT_PAYER;
    protected AuthMethod $authMethod = AuthMethod::SERVICE_USER;
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
