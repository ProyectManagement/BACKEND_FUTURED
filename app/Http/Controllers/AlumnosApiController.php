<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use MongoDB\BSON\ObjectId;

class AlumnosApiController extends Controller
{
    protected $collection;
    protected $db;

    public function __construct()
    {
        $client = new MongoClient(env('DB_URI'));
        $this->db = $client->selectDatabase(env('DB_DATABASE'));
        $this->collection = $this->db->alumnos;
    }

    public function index()
    {
        try {
            $alumnos = $this->collection->find()->toArray();
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

    public function getByMatricula($matricula)
    {
        try {
            $alumno = $this->collection->findOne(['matricula' => $matricula]);
            if (!$alumno) {
                return response()->json(['error' => 'Alumno no encontrado'], 404);
            }
            $gid = isset($alumno->id_grupo) ? (string) $alumno->id_grupo : '';
            $grupoNombre = '';
            if ($gid) {
                try {
                    $oid = new ObjectId($gid);
                    $grupo = $this->db->grupos->findOne(['_id' => $oid]);
                    $grupoNombre = $grupo->nombre ?? '';
                } catch (\Throwable $e) {
                }
            }
            return response()->json([
                '_id' => (string) $alumno->_id,
                'matricula' => $alumno->matricula ?? '',
                'nombre' => $alumno->nombre ?? '',
                'apellido_paterno' => $alumno->apellido_paterno ?? '',
                'apellido_materno' => $alumno->apellido_materno ?? '',
                'nombre_completo' => trim(($alumno->nombre ?? '') . ' ' . ($alumno->apellido_paterno ?? '') . ' ' . ($alumno->apellido_materno ?? '')),
                'id_grupo' => $gid,
                'nombre_grupo' => $grupoNombre
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
