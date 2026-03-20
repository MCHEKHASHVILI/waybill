<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Exceptions;

use Throwable;

/**
 * Thrown when the RS WaybillService endpoint cannot be reached.
 *
 * Causes: network timeout, DNS resolution failure, connection refused,
 * TLS handshake error, or any other transport-level problem.
 *
 * The original Saloon / cURL exception is available via getPrevious().
 */
class WaybillConnectionException extends WaybillServiceException
{
    public function __construct(string $message, Throwable $previous)
    {
        parent::__construct($message, previous: $previous);
    }
}
