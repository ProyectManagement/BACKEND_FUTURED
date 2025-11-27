<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as EloquentModel;  // Usa la clase correcta de MongoDB

class Grupo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'grupos';
    protected $fillable = ['nombre', 'id_carrera', 'id_tutor'];

    // Relación con el modelo Alumno
    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'id_grupo', '_id');
    }

    // Relación con el modelo Carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', '_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'id_tutor', '_id');
    }
}
