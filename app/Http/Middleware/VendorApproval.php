<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Auth::check()) {
            $userId = \Auth::id(); 
            $user = User::where('id',$userId)->first();
            if($user->is_vendor == 'yes'){
                return $next($request);
            }
        }
        
        return redirect('/');
    }
}
