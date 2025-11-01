<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // BotMan web widget endpoint
        'botman',
        'botman/*',

        // Temporarily disable CSRF for chat routes during testing
        'api/chat/*',
    ];
}
