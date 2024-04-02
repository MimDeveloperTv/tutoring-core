<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  
        if(!file_exists(base_path()."/domains/.".$request->header('domain')))
            return response()->json([
               'errors' => [
                  'message' => 'Domain not found!!! Please register your domain and try again.'
               ]
            ],425); 
        return $next($request);
    }
}
