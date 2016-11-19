<?php

namespace Aitor24\Laralang\Middleware;

use Closure;
use Crypt;

class LaralangMiddleware
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('laralang.password') || (Crypt::decrypt(session('laralang.password')) != config('laralang.default.password'))) {
            return redirect(Route('laralang::login'))->with('status', 'You should be logged into Laralang!');
        }

        return $next($request);
    }
}
