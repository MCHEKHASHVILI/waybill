<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\CheckServiceUserDto;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

class CheckServiceUserRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::CHECK_SERVICE_USER;

    public function __construct(protected mixed $params = []) {}

    public function hasRequestFailed(Response $response): ?bool
    {
        $body = $response->body();
        if (str_contains($body, '<html') || str_contains($body, 'Server Error')) {
            return true;
        }
        return null;
    }

    public function createDtoFromResponse(Response $response): CheckServiceUserDto
    {
        $body = $response->body();
        if (str_contains($body, '<html') || str_contains($body, 'Server Error')) {
            return new CheckServiceUserDto(active: false, tenant_id: 0, user_id: 0);
        }

        $data      = array_map(
            fn($val) => $val->getContent(),
            $response->xmlReader()->element("{$this->action->value}Response")->sole()->getContent()
        );
        $resultKey = "{$this->action->value}Result";

        return new CheckServiceUserDto(
            active:    strtolower((string) ($data[$resultKey] ?? '')) === 'true',
            tenant_id: (int) ($data['un_id']     ?? 0),
            user_id:   (int) ($data['s_user_id'] ?? 0),
        );
    }
}
