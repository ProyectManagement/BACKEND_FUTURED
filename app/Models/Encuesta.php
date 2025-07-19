<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as EloquentModel;

class Encuesta extends EloquentModel
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'encuestas';

    protected $fillable = [
            'matricula',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'sexo',
            'estado_civil',
            'vive_con',
            'sosten_economico',
            'tipo_vivienda',
            'pago_renta',
            'quien_presta_vivienda',
            'servicios',
            'acceso_internet',
            'lugar_conexion',
            'tiene_computadora',
            'electricidad_estable',
            'tipo_computadora',
            'acceso_impresora',
            'espacio_estudio',
            'trabaja',
            'horas_trabajo',
            'sueldo_suficiente',
            'recibe_beca',
            'considerado_abandono',
            'razon_abandono',
            'id_carrera',  // ✅ Agregado
            'id_grupo'    // ✅ Agregado
    ];
     // Relación con Grupo
     public function grupo()
     {
         return $this->belongsTo(Grupo::class, 'id_grupo', '_id');
     }
 
     // Relación con Carrera
     public function carrera()
     {
         return $this->belongsTo(Carrera::class, 'id_carrera', '_id');
     }
}
