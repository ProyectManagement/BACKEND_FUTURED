<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prediccion extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'predicciones';
    protected $fillable = ['id_alumno', 'matricula', 'fecha', 'riesgo', 'motivo', 'recomendacion', 'nombre_completo', 'nombre_grupo'];
}
