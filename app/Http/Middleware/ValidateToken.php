<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if($request->hasHeader('Authorization'))
        {
            $token = $request->header('Authorization');
            if(!$token){
                throw new \Exception('Request should have access token');
            }
            else{
               
            }
        } else {
            throw new \Exception('Request should have access token');
        }
        return $next($request);
    }
}
