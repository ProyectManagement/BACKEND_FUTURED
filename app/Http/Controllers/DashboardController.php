<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener el rol del usuario desde la relación
        $role = $user->role->nombre;  // Asumiendo que la relación en el modelo User está correctamente definida

        return view('dashboard', compact('user', 'role'));  // Pasamos el usuario y el rol
    }
}
