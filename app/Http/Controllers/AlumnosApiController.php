<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;

class AlumnosApiController extends Controller
{
    protected $collection;

    public function __construct()
    {
        $client = new MongoClient(env('DB_URI'));
        $db = $client->selectDatabase(env('DB_DATABASE'));
        $this->collection = $db->alumnos; // colección "alumnos"
    }

    // Devuelve todos los alumnos
    public function index()
    {
        try {
            $alumnos = $this->collection->find()->toArray();

            // Convertir ObjectId a string y fechas a string para JSON
            $result = array_map(function ($a) {
                return [
                    '_id' => (string) $a->_id,
                    'nombre' => $a->nombre ?? '',
                    'apellido_paterno' => $a->apellido_paterno ?? '',
                    'apellido_materno' => $a->apellido_materno ?? '',
                    'matricula' => $a->matricula ?? '',
                    'id_carrera' => $a->id_carrera ?? '',
                    'id_grupo' => $a->id_grupo ?? '',
                    'created_at' => isset($a->created_at) ? $a->created_at->toDateTime()->format('Y-m-d H:i:s') : null,
                    'updated_at' => isset($a->updated_at) ? $a->updated_at->toDateTime()->format('Y-m-d H:i:s') : null,
                ];
            }, $alumnos);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
