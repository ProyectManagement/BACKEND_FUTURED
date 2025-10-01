<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'app' => 'required|string|max:255',
            'apm' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,correo',
            'contraseña' => 'required|string|min:8|confirmed',
            'id_rol' => 'required|exists:roles,_id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = User::create([
            'nombre' => $request->nombre,
            'app' => $request->app,
            'apm' => $request->apm,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'id_rol' => $request->id_rol,
        ]);

        Auth::login($user);
        return $this->redirectBasedOnRole($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                             ->withErrors($validator)
                             ->withInput();
        }

        $credentials = $request->only('correo', 'contraseña');
        $user = User::where('correo', $credentials['correo'])->first();

        if ($user && Hash::check($credentials['contraseña'], $user->contraseña)) {
            Auth::login($user);
            return $this->redirectBasedOnRole($user);
        }

        return redirect()->route('login')->withErrors(['correo' => 'Credenciales incorrectas']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }

   protected function redirectBasedOnRole($user)
{
    $role = $user->role;
    \Log::info('Rol del usuario: ' . ($role ? $role->nombre : 'No encontrado'));

    if ($role && $role->nombre === 'Administrador') {
        return redirect()->route('users.index');
    } elseif ($role && $role->nombre === 'Tutor') {
        return redirect()->route('dashboard');
    }

    return redirect()->route('dashboard');
}
}