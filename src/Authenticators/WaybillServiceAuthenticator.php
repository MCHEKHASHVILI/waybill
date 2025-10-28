<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Authenticators;

use Saloon\Http\PendingRequest;
use Saloon\Contracts\Authenticator;
use Mchekhashvili\RsWaybill\Enums\AuthMethod;
use Mchekhashvili\RsWaybill\Requests\BaseRequest;

class WaybillServiceAuthenticator implements Authenticator
{
    public function __construct(
        public readonly string|null $service_username = null,
        public readonly string|null $service_password = null,
        public readonly string|null $tenant_username = null,
        public readonly string|null $tenant_password = null
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        /**
         * @var BaseRequest $baseRequest
         */
        $baseRequest = $pendingRequest->getRequest();

        match ($baseRequest->getAuthMethod()) {
            AuthMethod::TENANT => $this->authenticateTenant($baseRequest),
            AuthMethod::SERVICE_USER => $this->authenticateServiceUser($baseRequest),
            AuthMethod::BOTH => (function ($request) {
                $this->authenticateTenant($request);
                $this->authenticateServiceUser($request);
            })($baseRequest),
            default => self::actAsGuest($baseRequest)
        };
    }

    protected function authenticateTenant(BaseRequest $baseRequest): void
    {
        $baseRequest->setAuthParams([
            'user_name' => $this->tenant_username,
            'user_password' => $this->tenant_password,
        ]);
    }
    protected function authenticateServiceUser(BaseRequest $baseRequest): void
    {
        $baseRequest->setAuthParams([
            'su' => $this->service_username,
            'sp' => $this->service_password,
        ]);
    }
    private static function actAsGuest(BaseRequest $baseRequest): void
    {
        // ...
    }
}
