<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reporte extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reporte';

    protected $fillable = [
        '_id', 
        'titulo', 
        'descripcion', 
        'archivo', 
        'compartido', 
        'usuario_id', 
        'created_at', 
        'updated_at'
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Añade esta relación
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }
}