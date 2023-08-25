<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards): Response
    {
        $username = $request->getUser();
        $password = $request->getPassword();

        $user = User::where('email', $username)->first();

        if (! $user || ! password_verify($password, $user->password)) {
            return response()->json([
                'success' => false,
                'auth' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
