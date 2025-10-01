<?php

namespace App\Http\Controllers;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class GruposApiController extends Controller
{
    private $db;

    public function __construct()
    {
        $client = new Client(env('DB_URI'));
        $this->db = $client->selectDatabase(env('DB_DATABASE'));
    }

    // Devuelve todos los grupos de una carrera específica
    public function getByCarrera($idCarrera)
    {
        try {
            $grupos = $this->db->grupos->find(['id_carrera' => new ObjectId($idCarrera)]);
            return response()->json(iterator_to_array($grupos));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
