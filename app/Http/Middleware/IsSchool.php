<?php

namespace App\Http\Middleware;

use Closure;

class IsSchool
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()['role_id'] == 2) {
            $organisation = \App\Organisation::where('organisations.director_id', \Auth::id())->first();
            if (!$organisation->is_school) {
                abort(403);
            }
        }

        return $next($request);
    }
}
