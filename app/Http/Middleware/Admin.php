<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in
        $user = Auth::user();
        $path = request()->path();
        if (Auth::check()) {
           if($user){
                return $next($request);
           }else {
                // Redirect or return a response for unauthorized access
                abort(403, 'Unauthorized');
           }
            
        }else {
            return redirect("/login?urlRequest={$path}");
        }
    }
}
