<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prediccion;
use Validator;

class IaController extends Controller
{
    /**
     * Obtiene predicciones desde la API de IA y guarda en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function obtenerPredicciones(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_alumno' => 'required|string',
            // Agregar más validaciones si es necesario
        ]);

        // Si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        // Enviar los datos al modelo de IA (API FastAPI)
        try {
            $respuesta = Http::post('http://localhost:8001/predict', $request->all());

            if ($respuesta->failed()) {
                return response()->json(['message' => 'Error en la respuesta de la API de IA.'], 500);
            }

            $predicciones = $respuesta->json()['predicciones']; // Asumiendo que 'predicciones' es la clave

            // Guardar las predicciones en MongoDB
            foreach ($predicciones as $prediccion) {
                Prediccion::create([
                    'id_alumno' => $prediccion['alumno_id'],
                    'fecha' => now(),
                    'riesgo' => $prediccion['resultado'],
                ]);
            }

            return response()->json([
                'message' => 'Predicciones guardadas correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al comunicarse con la API de IA: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtiene todas las predicciones.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $predicciones = Prediccion::all();
        return response()->json($predicciones);
    }

    /**
     * Obtiene una predicción específica.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prediccion = Prediccion::find($id);

        if (!$prediccion) {
            return response()->json([
                'message' => 'Predicción no encontrada.'
            ], 404);
        }

        return response()->json($prediccion);
    }
}
