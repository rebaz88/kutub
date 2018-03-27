<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class VerifyIsAgent
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
        $userAgency = Auth::user()->agents()->get();

        if ($userAgency->isEmpty()) {
            return redirect('/should-be-an-agent');
        }

        $input = $request->all();
        $input['current_user_agent_id'] = $userAgency->first()->id;
        $request->replace($input);

        return $next($request);
    }
}
