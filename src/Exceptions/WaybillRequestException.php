<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Exceptions;

use Throwable;

/**
 * Thrown when the RS API returns a SOAP fault or an unsuccessful
 * business response (e.g. waybill not found, operation not permitted).
 *
 * The raw response body is available via getResponseBody() for
 * debugging or logging purposes.
 */
class WaybillRequestException extends WaybillServiceException
{
    public function __construct(
        string           $message,
        private readonly string $responseBody,
        int              $code      = 0,
        Throwable|null   $previous  = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getResponseBody(): string
    {
        return $this->responseBody;
    }
}
