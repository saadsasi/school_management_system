<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    

     public function handle(Request $request, Closure $next): Response
     {
         if (Auth::check()) {
             $user = Auth::user();
             $user->refresh(); // تحديث بيانات المستخدم
     
             if ($user->user_type == 2) {
                 if ($user->is_supervisor == 1) {
                     return $next($request);
                 }
     
                 if (!$request->is('admin/*')) {
                     return $next($request);
                 }
     
                 return redirect('/');
             }
         }
     
         Auth::logout();
         return redirect('/');
     }
     

    
}
