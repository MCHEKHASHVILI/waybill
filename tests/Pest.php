<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

pest()->extend(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
|
| Credentials are read from environment variables.
| Copy .env.example to .env and fill in your values to run integration tests.
|
*/

function getTenantCredentials(): array
{
    return [
        'user_name' => $_ENV['RS_TENANT_USERNAME'] ?? '',
        'user_password' => $_ENV['RS_TENANT_PASSWORD'] ?? '',
    ];
}

function getServiceUserCredentials(): array
{
    return [
        'su' => $_ENV['RS_SERVICE_USERNAME'] ?? '',
        'sp' => $_ENV['RS_SERVICE_PASSWORD'] ?? '',
    ];
}

function getToday(): string
{
    return (new DateTimeImmutable())->format('Y-m-d');
}

function getYesterday(): string
{
    return (new DateTimeImmutable())->modify('-1 day')->format('Y-m-d');
}

/**
 * Returns true only when real credentials are available in the environment.
 * Integration tests should be skipped when they are not.
 */
function hasCredentials(): bool
{
    return !empty($_ENV['RS_SERVICE_USERNAME']) && !empty($_ENV['RS_SERVICE_PASSWORD']);
}
