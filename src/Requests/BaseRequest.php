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
    /**
     * RS WaybillService accepts Method::POST for every request
     * @var Method
     */
    protected Method $method = Method::POST;
    /**
     * Define the SOAP action.
     */
    protected Action $action;
    /**
     * Dequest body params accepted in actual request constructor
     * @var mixed
     */
    protected mixed $params;
    /**
     * Define Auth method for request
     * @var AuthMethod
     */
    protected AuthMethod $authMethod = AuthMethod::SERVICE_USER;
    /**
     * It is "/" for every Request
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return "/";
    }
    /**
     * Get the method of the request.
     * @return \Mchekhashvili\RsWaybill\Enums\Action
     */
    public function getAction(): Action
    {
        if (! isset($this->action)) {
            throw new ActionPropertyIsNotSetException;
        }

        return $this->action;
    }
    /**
     * Same for each request
     * @return array{filter[active]: string, sort: string}
     */
    protected function defaultQuery(): array
    {
        return ["op" => $this->action->value];
    }
    public function getAuthMethod(): AuthMethod
    {
        return $this->authMethod;
    }
    /**
     * Generating string body using params
     * @return string
     */
    abstract public function createXmlBodyFromParams(): string;
    /**
     * Setting body authenticator purpose
     * @return string
     */
    abstract public function setAuthParams(array $params): void;
}
