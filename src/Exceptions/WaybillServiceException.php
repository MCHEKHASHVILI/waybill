<?php

declare(strict_types=1);

namespace Mchekhashvili\Rs\Waybill\Exceptions;

use RuntimeException;

/**
 * Base exception for all RS WaybillService SDK errors.
 *
 * Catching this type is sufficient to handle every failure
 * this SDK can produce. Sub-classes allow callers to react
 * differently to network problems vs. server errors vs. API faults.
 *
 * Hierarchy:
 *   WaybillServiceException
 *     WaybillConnectionException  — network/transport failure (timeout, DNS, etc.)
 *     WaybillServerException      — RS server returned an HTML error page
 *     WaybillRequestException     — RS API returned a SOAP fault or business error
 */
class WaybillServiceException extends RuntimeException {}
