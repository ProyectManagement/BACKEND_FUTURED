<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Asesoria extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'asesorias';
    protected $fillable = ['_id', 'alumno_id', 'fecha', 'tema', 'created_at', 'updated_at'];
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', '_id');
    }
}