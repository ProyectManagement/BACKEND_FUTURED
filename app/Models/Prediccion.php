<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Prediccion extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'predicciones';
    protected $fillable = ['id_alumno', 'fecha', 'riesgo'];
}
