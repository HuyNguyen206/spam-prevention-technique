<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HoneyPot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $configHoneyPot = config('honeypot');
        if(! $configHoneyPot['enable']) {
            return $next($request);
        }
        if (! $request->has($configHoneyPot['field_name'])) { // normal/valid user will always send this field name
            $this->abort();
        }

        if ($request->get($configHoneyPot['field_name'])) { // normal/valid user will always send this field name with empty/null value
            $this->abort();
        }

        $currentTime = microtime(true);
        if ($currentTime - $request->get($configHoneyPot['field_time_name']) <= $configHoneyPot['minimum_time']) { // fill data to quick
            $this->abort();
        }

        return $next($request);
    }

    /**
     * @return void
     */
    public function abort(): void
    {
        abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'Spam detected');
    }
}
