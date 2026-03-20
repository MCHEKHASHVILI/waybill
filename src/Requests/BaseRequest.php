<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Requests;

use Mchekhashvili\Rs\Waybill\Enums\AuthMethod;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Mchekhashvili\Rs\Waybill\Enums\Action;
use Mchekhashvili\Rs\Waybill\Exceptions\ActionPropertyIsNotSetException;

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

    abstract public function createXmlBodyFromParams(): string;
    abstract public function setAuthParams(array $params): void;
}
