<?php

namespace App\Http\Middleware;

use Closure;

class GuestApiMiddleware
{
    protected $guestControllers = [
        'Posts',
        'Comments'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(in_array(class_basename(Route::current()->controller),$this->guestControllers)){

        }
        return $next($request);
    }
}
