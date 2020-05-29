<?php

namespace App\Http\Middleware;

use Closure;

class HasAssociation
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
        if (\Auth::user()['role_id'] == 3) {
            $association = \DB::table('teachers')
                ->where('teachers.user_id', \Auth::id())
                ->value('association_id');

            $organisation = \DB::table('teachers')
                ->join('associations',
                    'teachers.association_id', '=', 'associations.id')
                ->where('teachers.user_id', \Auth::id())
                ->value('associations.organisation_id');

            if (!$association) {
                abort(403);
            }
            $request->attributes->add([
                'hasOrganisation' => $organisation,
                'hasAssociation' => $association,
            ]);
        }

        return $next($request);
    }
}
