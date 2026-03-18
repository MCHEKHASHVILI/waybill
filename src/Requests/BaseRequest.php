<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Requests;

use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Mchekhashvili\RsWaybill\Enums\Action;
use Mchekhashvili\RsWaybill\Exceptions\ActionPropertyIsNotSetException;

abstract class BaseRequest extends Request
{
    /** RS WaybillService accepts POST for every request */
    protected Method $method = Method::POST;

    /** The SOAP action for this request — must be set on every concrete class */
    protected Action $action;

    /** Request body params passed via the constructor */
    protected mixed $params;

    /** Authentication mode — defaults to SERVICE_USER for most requests */
    protected AuthMethod $authMethod = AuthMethod::SERVICE_USER;

    public function resolveEndpoint(): string
    {
        return '/';
    }

    public function getAction(): Action
    {
        if (! isset($this->action)) {
            throw new ActionPropertyIsNotSetException();
        }

        return $this->action;
    }

    protected function defaultQuery(): array
    {
        return ['op' => $this->action->value];
    }

    public function getAuthMethod(): AuthMethod
    {
        return $this->authMethod;
    }

    abstract public function createXmlBodyFromParams(): string;

    abstract public function setAuthParams(array $params): void;
}
