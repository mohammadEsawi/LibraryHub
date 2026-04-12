<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login.form');
        }

        if (!in_array($user->role, $roles, true)) {
            return redirect()->route('books.index')->with('error', 'لا تملك صلاحية للوصول لهذه الصفحة.');
        }

        return $next($request);
    }
}
