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

    public function __construct(
        public readonly string|null $service_username = null,
        public readonly string|null $service_password = null,
        public readonly string|null $tenant_username = null,
        public readonly string|null $tenant_password = null
    ) {}

    protected function defaultAuth(): WaybillServiceAuthenticator
    {
        return new WaybillServiceAuthenticator(
            $this->service_username,
            $this->service_password,
            $this->tenant_username,
            $this->tenant_password
        );
    }

    public function resolveBaseUrl(): string
    {
        // The RS server requires the ?WSDL suffix to correctly route SOAP POST requests.
        // Using the bare .asmx URL causes the server to return an HTML error page.
        return 'https://services.rs.ge/WayBillService/WayBillService.asmx?WSDL';
    }

    public function boot(PendingRequest $pendingRequest): void
    {
        /** @var BaseRequest $baseRequest */
        $baseRequest = $pendingRequest->getRequest();

        $pendingRequest->body()->set($baseRequest->createXmlBodyFromParams());
        $pendingRequest->headers()->add('Content-Type', 'text/xml; charset=UTF-8');
        $pendingRequest->headers()->add('SOAPAction', 'http://tempuri.org/' . $baseRequest->getAction()->value);
        $pendingRequest->headers()->add('Content-Length', strlen($pendingRequest->body()->all()));
    }
}
