<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifiedPayment
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
        if(Auth::user()->role_id != 1) {
            $date = date('Y-m-d H:i', strtotime(Auth::user()->subscription_expire));
            if($date > date('Y-m-d H:i')){
                return redirect('/');
            }
            return $next($request);
        } else{
            return $next($request);
        }
    }
}
