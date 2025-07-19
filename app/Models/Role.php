<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mongodb';  // Especificamos que usa MongoDB
    protected $collection = 'roles';    // Nombre de la colección en MongoDB
    protected $primaryKey = '_id';      // MongoDB usa `_id` como clave primaria

    protected $fillable = ['nombre'];
}