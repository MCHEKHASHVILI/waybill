<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Traits\Requests\HasParams;
use Mchekhashvili\Rs\Waybill\Dtos\Waybill\CheckServiceUserDto;
use Mchekhashvili\Rs\Waybill\Interfaces\Requests\HasParamsInterface;

/**
 * CheckServiceUserRequest is the only request that overrides hasRequestFailed().
 *
 * The RS chek_service_user endpoint returns an HTML error page for any
 * call with missing or invalid credentials — rather than a SOAP fault.
 * Instead of throwing WaybillServerException like the base class would,
 * this request catches the HTML page and returns a safe inactive DTO,
 * making it possible to use this endpoint as a credentials check.
 */
class CheckServiceUserRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::CHECK_SERVICE_USER;

    public function __construct(protected mixed $params = []) {}

    /**
     * Suppress the base class HTML-page detection so createDtoFromResponse()
     * can handle it gracefully instead of throwing.
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        return null;
    }

    public function createDtoFromResponse(Response $response): CheckServiceUserDto
    {
        $body = $response->body();

        // HTML error page — credentials rejected by RS server
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
