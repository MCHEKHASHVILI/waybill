<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Connectors;

use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\Http\Response;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasXmlBody;
use Saloon\Exceptions\Request\FatalRequestException;
use Mchekhashvili\Rs\Waybill\Authenticators\WaybillServiceAuthenticator;
use Mchekhashvili\Rs\Waybill\Exceptions\WaybillConnectionException;
use Mchekhashvili\Rs\Waybill\Requests\BaseRequest;

class WaybillServiceConnector extends Connector implements HasBody
{
    use HasXmlBody;

    public function __construct(
        public readonly string|null $service_username = null,
        public readonly string|null $service_password = null,
        public readonly string|null $tenant_username  = null,
        public readonly string|null $tenant_password  = null
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
        // Plain .asmx endpoint — correct target for SOAP POST requests.
        // The ?WSDL suffix is for WSDL document retrieval only and must
        // NOT be used here: Saloon appends query params after it, producing
        // malformed URLs like ?WSDL= or ?WSDL%2F= that cause timeouts.
        return 'https://services.rs.ge/WayBillService/WayBillService.asmx';
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

    /**
     * Intercepts Saloon's FatalRequestException (network/transport failures)
     * and re-throws as WaybillConnectionException so consumers only need
     * to catch SDK-level exceptions.
     *
     * @throws WaybillConnectionException
     */
    public function handleSendException(FatalRequestException $exception): Response
    {
        throw new WaybillConnectionException(
            message:  'Could not connect to the RS WaybillService: ' . $exception->getMessage(),
            previous: $exception,
        );
    }
}
