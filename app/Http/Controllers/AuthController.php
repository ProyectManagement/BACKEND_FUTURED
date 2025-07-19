<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Mostrar formulario de registro con roles disponibles
    public function showRegisterForm()
    {
        $roles = Role::all(); // Obtener todos los roles de MongoDB
        return view('auth.register', compact('roles'));
    }

    // Registrar un nuevo usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'app' => 'required|string|max:255',
            'apm' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,correo',
            'contraseña' => 'required|string|min:6|confirmed',
            'id_rol' => 'required|exists:roles,_id', // Asegura que el ID del rol exista en la colección de roles
        ]);

        if ($validator->fails()) {
            return redirect()->route('register.form')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Crear usuario en MongoDB
        $user = User::create([
            'nombre' => $request->nombre,
            'app' => $request->app,
            'apm' => $request->apm,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'id_rol' => $request->id_rol, // Guardar el ID del rol seleccionado
        ]);

        // Iniciar sesión inmediatamente después de registrar el usuario
        Auth::login($user);

        // Redirigir al dashboard
        return redirect()->route('dashboard');
    }

    // Autenticación del usuario
    public function login(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->only('correo', 'contraseña');
        $user = User::where('correo', $credentials['correo'])->first();

        // Verificar si las credenciales son correctas
        if ($user && Hash::check($credentials['contraseña'], $user->contraseña)) {
            Auth::login($user);
            return redirect()->route('dashboard');  // Redirige al dashboard
        }

        // Si las credenciales son incorrectas
        return redirect()->route('login')->withErrors(['correo' => 'Credenciales incorrectas']);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
