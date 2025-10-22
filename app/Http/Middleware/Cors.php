<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if it is the preflight request
        if ($request->isMethod('OPTIONS')) {
            // Create an empty response
            $response = response('', 204); // Use 204 No Content for OPTIONS
        } else {
            // Continue with the actual request
            $response = $next($request); 
        }

        // Set ALL necessary CORS headers on the response
        $response->headers->set('Access-Control-Allow-Origin', '*'); 
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Auth-Token, Origin, Authorization');
        
        // Return the response, which now includes the headers
        return $response;
    }

}
