<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;  // Usa esta clase en lugar de Jenssegers\Mongodb\Auth\User
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


class User extends Eloquent implements AuthenticatableContract
{
    use Notifiable, CanResetPassword, AuthenticatableTrait;

    protected $connection = 'mongodb';  // Usa MongoDB como conexión
    protected $collection = 'users';    // Especificamos la colección de usuarios
    protected $primaryKey = '_id';      // MongoDB usa _id como clave primaria
    protected $fillable = [
        'nombre', 'app', 'apm', 'correo', 'contraseña', 'id_rol'
    ];

    protected $hidden = [
        'contraseña', 'remeber_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['contraseña'] = Hash::make($value);
    }

    // Relación con el modelo Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_rol', '_id');
    }
}
