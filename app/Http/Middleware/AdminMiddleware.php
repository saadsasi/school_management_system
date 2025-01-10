<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!empty(Auth::check()))
        {
            $user = Auth::user();
            // السماح للمشرف أو المعلم المشرف
            if($user->user_type == 1 || ($user->user_type == 2 && $user->is_supervisor == 1))
            {
                return $next($request);    
            }
            else
            {
                Auth::logout();
                return redirect(url(''));
            }            
        }
        else
        {
            Auth::logout();
            return redirect(url(''));
        }
    }
}
