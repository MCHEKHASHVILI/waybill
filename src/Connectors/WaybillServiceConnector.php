<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Connectors;

use Mchekhashvili\RsWaybill\Authenticators\WaybillServiceAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasXmlBody;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;

class WaybillServiceConnector extends Connector implements HasBody
{
    use HasXmlBody;

    /**
     * Summary of __construct
     * @param string|null $service_username
     * @param string|null $service_password
     * @param string|null $tenant_username
     * @param string|null $tenant_password
     */
    public function __construct(
        public readonly string|null $service_username = null,
        public readonly string|null $service_password = null,
        public readonly string|null $tenant_username = null,
        public readonly string|null $tenant_password = null
    ) {}

    protected function defaultAuth(): WaybillServiceAuthenticator
    {
        return new WaybillServiceAuthenticator($this->service_username, $this->service_password, $this->tenant_username, $this->tenant_password);
    }

    public function resolveBaseUrl(): string
    {
        return "https://services.rs.ge/WayBillService/WayBillService.asmx?WSDL";
    }

    /**
     * Actions before sending the request
     * 
     * @return void
     */
    public function boot(PendingRequest $pendingRequest): void
    {
        /**
         * @var BaseRequest $baseRequest
         */
        $baseRequest = $pendingRequest->getRequest();
        // set body
        $pendingRequest->body()->set($baseRequest->createXmlBodyFromParams());
        // modify headers
        $pendingRequest->headers()->add("Content-Type", "text/xml; charset=UTF-8");
        $pendingRequest->headers()->add("SOAPAction", "http://tempuri.org/" . $baseRequest->getAction()->value);
        $pendingRequest->headers()->add("Content-Length", strlen($pendingRequest->body()->all()));
    }
}
