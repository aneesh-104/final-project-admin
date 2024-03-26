<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt; // Import Crypt 
use Exception;



class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
            try{

                $cookieValue = $request->cookie('token');

                if (!$request->token) {
                    throw new Exception('Token not available');
                }

                $decryptedPayload = json_decode(Crypt::decrypt($request->token), true);
                
                
                $userRole = $decryptedPayload['role'];

            }catch(Exception $error){

                return response()->json(['error' => $error->getMessage()], 401);

            }

        $request->userInfo = $decryptedPayload;

        if ($userRole !== 'donor' && $userRole !== 'fundraiser') {

            return response()->json(['error' => 'Unauthorized'], 401);

        }
        
        return $next($request);
    }
}
