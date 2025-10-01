<?php

namespace App\Http\Controllers;

use MongoDB\Client;

class CarrerasApiController extends Controller
{
    public function index()
    {
        $client = new Client(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->carreras;

        $carreras = $collection->find()->toArray();

        return response()->json($carreras);
    }
}
