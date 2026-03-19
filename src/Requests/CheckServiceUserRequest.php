<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Saloon\Http\Response;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Traits\Requests\HasParams;
use Mchekhashvili\RsWaybill\Dtos\Static\CheckServiceUserDto;
use Mchekhashvili\RsWaybill\Interfaces\Requests\HasParamsInterface;

class CheckServiceUserRequest extends BaseRequest implements HasParamsInterface
{
    use HasParams;

    protected Action $action = Action::CHECK_SERVICE_USER;

    public function __construct(protected mixed $params = []) {}

    /**
     * The RS API returns an HTML error page (not a SOAP fault) when credentials
     * are missing or invalid. We detect this before attempting XML parsing.
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        $body = $response->body();

        // RS server returns an HTML page on auth failure instead of a SOAP response
        if (str_contains($body, '<html') || str_contains($body, 'Server Error')) {
            return true;
        }

        return null;
    }

    public function createDtoFromResponse(Response $response): CheckServiceUserDto
    {
        // If the response is not valid XML (e.g. HTML error page from the server),
        // return a safe inactive DTO rather than crashing the XML parser.
        $body = $response->body();
        if (str_contains($body, '<html') || str_contains($body, 'Server Error')) {
            return new CheckServiceUserDto(active: false, tenant_id: 0, user_id: 0);
        }

        $data = array_map(
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
