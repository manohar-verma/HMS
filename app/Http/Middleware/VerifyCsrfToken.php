<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    protected function tokensMatch($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        $sessionToken = $request->session()->token();

        if ($token !== $sessionToken) {
            \Log::error('CSRF mismatch', [
                'form_token' => $token,
                'session_token' => $sessionToken,
                'cookies' => request()->cookies->all(),
            ]);
        }

        return parent::tokensMatch($request);
    }
}
