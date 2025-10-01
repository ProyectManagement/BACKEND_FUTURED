<?php
namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;
class Reporte extends Model {
    protected $connection = 'mongodb';
    protected $collection = 'reportes';
    protected $fillable = ['nombre_archivo', 'archivo', 'fecha'];
}