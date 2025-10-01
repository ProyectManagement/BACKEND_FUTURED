<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();
        if ($user) {
            $user->load('role'); // Cargar la relación role explícitamente
            $userRole = $user->role;

            if ($userRole && $userRole->nombre === $role) {
                return $next($request);
            }
        }

        return redirect()->route('dashboard')->withErrors(['access' => 'No tienes permiso para acceder a esta sección']);
    }
}