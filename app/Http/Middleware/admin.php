<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class admin
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
        $user = Sentinel::getUser();
        if($user && $user->is_admin == 1)
        {    
            return $next($request);
        }
        return redirect('admin/login');
    }
}
