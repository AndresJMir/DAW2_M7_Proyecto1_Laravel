<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// class EnsureUserHasRole
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         return $next($request);
//     }
// }

class EnsureUserHasRole
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @param  int  $role
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
   public function handle(Request $request, Closure $next, $role)
   {
       if ($request->user()->role_id != $role) {
           $url = $request->url();
           return redirect('home')
               ->with('error', "Access denied to {$url}");
       }


       return $next($request);
   }
}

