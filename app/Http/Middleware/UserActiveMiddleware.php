<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class UserActiveMiddleware
{

public function handle(Request $request, Closure $next)
{
    if(!empty(Auth::check()))
    {
        if(Auth::user()->status == 0)
        {
            return $next($request);    
        }
        else
        {
            Auth::logout();
            return redirect(url('/'))->withErrors(
                'Your account is inactive'
            );
        }            
    }
    else
    {
        Auth::logout();
        return redirect(url('/'))->withErrors(
            'Your account is inactive'
        );
    }


}

}