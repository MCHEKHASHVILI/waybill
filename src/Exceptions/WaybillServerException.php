<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Exceptions;

use Throwable;

/**
 * Thrown when the RS server responds with an HTML error page
 * instead of a SOAP response.
 *
 * This typically indicates an authentication failure, a request
 * the RS server does not accept, or a transient RS-side runtime error.
 *
 * The raw response body is available via getResponseBody().
 */
class WaybillServerException extends WaybillServiceException
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
