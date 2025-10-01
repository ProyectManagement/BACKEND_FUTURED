<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InteligenciaController extends Controller
{
   public function predecir($matricula)
{
    if (!$matricula) {
        return response()->json(['error' => 'No se proporcionó matrícula'], 400);
    }

    $ruta_python = base_path('../IA-IA/prediccion_alumno.py');
    if (!file_exists($ruta_python)) {
        return response()->json(['error' => "Archivo Python no encontrado en $ruta_python"], 500);
    }

    $matricula_escapada = escapeshellarg($matricula);

    $output = shell_exec("python $ruta_python $matricula_escapada 2>&1");

    if (!$output) {
        return response()->json(['error' => 'Python no devolvió ningún resultado'], 500);
    }

    $resultado = json_decode($output, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return response()->json([
            'error' => 'Error decodificando JSON de Python',
            'raw_output' => mb_convert_encoding($output, 'UTF-8', 'UTF-8'),
            'json_error' => json_last_error_msg()
        ], 500);
    }

    // Convertir todos los strings a UTF-8 antes de devolver
    array_walk_recursive($resultado, function (&$item) {
        if (is_string($item)) {
            $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
        }
    });

    return response()->json($resultado);
}
}