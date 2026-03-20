<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Enums\AuthMethod;
use Mchekhashvili\Rs\Waybill\Exceptions\ActionPropertyIsNotSetException;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillServerException;

abstract class BaseRequest extends Request
{
    protected Method     $method     = Method::POST;
    protected Action     $action;
    protected mixed      $params;
    protected AuthMethod $authMethod = AuthMethod::SERVICE_USER;

    public function resolveEndpoint(): string { return ''; }

    public function getAction(): Action
    {
        if (! isset($this->action)) {
            throw new ActionPropertyIsNotSetException();
        }
        return $this->action;
    }

    public function getAuthMethod(): AuthMethod { return $this->authMethod; }

    /**
     * Central HTML error-page guard, applied to every request.
     *
     * The RS server returns an HTML Runtime Error page instead of a SOAP
     * response when it rejects a request (auth failure, bad input, internal
     * server error). Returning true here marks the response as failed before
     * createDtoFromResponse() is called, preventing the XML parser from
     * crashing on HTML content.
     *
     * Individual requests may still override this method if they need to
     * inspect the response body themselves (e.g. CheckServiceUserRequest
     * which must return a safe DTO instead of throwing).
     *
     * @throws WaybillServerException
     */
    public function hasRequestFailed(Response $response): ?bool
    {
        $body = $response->body();

        if (str_contains($body, '<html') || str_contains($body, 'Server Error')) {
            throw new WaybillServerException(
                message:      'The RS server returned an error page instead of a SOAP response.',
                responseBody: $body,
            );
        }

        return null;
    }

    abstract public function createXmlBodyFromParams(): string;
    abstract public function setAuthParams(array $params): void;
}
