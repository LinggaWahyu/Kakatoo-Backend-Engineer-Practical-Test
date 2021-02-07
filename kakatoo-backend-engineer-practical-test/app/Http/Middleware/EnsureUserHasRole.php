<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        
        $token = hash('sha256', $request->header('Authorization'));
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        } else if ($user->profile->name != $role && $role != 'all') {
            return dd($role);
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        } else {
            return $next($request);
        }
    }
}
