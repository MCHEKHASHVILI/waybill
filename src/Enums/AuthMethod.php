<?php

declare(strict_types=1);

namespace Mchekhashvili\RsWaybill\Enums;

enum AuthMethod
{
    /** No authentication — public endpoints like GetServerTime, WhatIsMyIp */
    case GUEST;
    /** Company (tenant) credentials only */
    case TENANT;
    /** Service-user credentials only — default for most requests */
    case SERVICE_USER;
    /** Both tenant and service-user credentials */
    case BOTH;
}
