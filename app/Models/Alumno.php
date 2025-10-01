<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Alumno extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'alumnos';
    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'matricula', 'id_carrera', 'id_grupo', 'id_users'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', '_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', '_id');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', '_id');
    }

    public function asesorias()
    {
        return $this->hasMany(Asesoria::class, 'alumno_id', '_id');
    }
}