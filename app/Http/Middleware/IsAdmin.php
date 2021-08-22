<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->name !== "Prabeg Shakya") {
            return response()->json([
                "status" => "Failed",
                "admin" => "Only admin is allowed to perform the action"
            ], 403);
        }
        return $next($request);
    }
}
