<?php

namespace Expand\We7\Middlewares;

use App\Helpers\RequestHelpers;
use Closure;
use Illuminate\Http\Request;

class We7Adaptation
{
    use RequestHelpers;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('IS_WE7') && $request->input('route-url')) {

            $request = request()
                ->propertyAware('pathInfo', \Illuminate\Support\Str::start($this->request('route-url'), '/'))
                ->propertyAware('method', $request->method());

        }

        return $next($request);
    }
}
