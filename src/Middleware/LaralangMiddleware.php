<?php

namespace Aitor24\Laralang\Middleware;

use Crypt;
use Closure;

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
        if (! session('laralang.password') || (Crypt::decrypt(session('laralang.password')) != config('laralang.default.password'))) {
            return redirect()
                ->route('laralang::login')
                ->with('msg', 'Your login has expired or does not exist.');
        }
        return $next($request);
    }
}
