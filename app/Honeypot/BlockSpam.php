<?php

namespace App\Honeypot;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockSpam
{
    /**
     * @var Honeypot
     */
    private $honeypot;

    public function __construct(Honeypot $honeypot)
    {
        $this->honeypot = $honeypot;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->honeypot->detectSpam($request)) {
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
