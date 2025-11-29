<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $roleTutor = Role::where('nombre', 'Tutor')->first();
        $users = $roleTutor ? User::with('role')->where('id_rol', $roleTutor->_id)->get() : collect();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'app' => 'required|string|max:255',
            'apm' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,correo',
            'contraseña' => 'required|string|min:8',
            'id_rol' => 'required|exists:roles,_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        User::create([
            'nombre' => $request->nombre,
            'app' => $request->app,
            'apm' => $request->apm,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'id_rol' => $request->id_rol,
        ]);

        return response()->json(['message' => 'Usuario creado con éxito'], 201);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userArray = $user->toArray();
        $userArray['_id'] = $user->_id;
        if (isset($userArray['id'])) {
            unset($userArray['id']);
            }
        // Depuración: Loguear los datos devueltos
        \Log::info('Datos del usuario en edit:', ['user' => $user->toArray(), 'roles' => $roles->toArray()]);
        return response()->json(['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'app' => 'required|string|max:255',
            'apm' => 'required|string|max:255',
            'correo' => ['required', 'email', 'unique:users,correo,' . $id . ',_id'],
            'contraseña' => 'nullable|string|min:8',
            'id_rol' => 'required|exists:roles,_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);
        $user->update([
            'nombre' => $request->nombre,
            'app' => $request->app,
            'apm' => $request->apm,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña ? Hash::make($request->contraseña) : $user->contraseña,
            'id_rol' => $request->id_rol,
        ]);

        return response()->json(['message' => 'Usuario actualizado con éxito'], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente'], 200);
    }
}
