<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Alumno extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'alumnos';
    protected $fillable = ['nombre', 'app', 'apm', 'id_carrera', 'id_grupo'];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', '_id');
    }
    
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera', '_id');
    }
}