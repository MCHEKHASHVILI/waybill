<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Dtos\Static\CheckServiceUser;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class CheckServiceUserRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;
    protected Action $action = Action::CHECK_SERVICE_USER;
    public function __construct(protected mixed $params = []) {}
    public function createDtoFromResponse(Response $response): CheckServiceUser
    {
        $data = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );

        return new CheckServiceUser(
            registered: strtolower((string) $data["{$this->action->value}Result"]) === "true",
            tenant_id: (int) $data['un_id'],
            user_id: (int) $data['s_user_id'],
        );
    }
}
