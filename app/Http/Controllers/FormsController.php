<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
use Validator;

class FormsController extends Controller
{
    /**
     * Almacena las respuestas de la encuesta.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'id_alumno' => 'required|string',
            'estado_civil' => 'required|string',
            'con_quien_vive' => 'required|string',
            'sosten_economico' => 'required|string',
            'donde_vives' => 'required|string',
            'cuanto_pagas_renta' => 'nullable|numeric',
            'quien_presta_vivienda' => 'nullable|string',
            'servicios_en_casa' => 'nullable|string',
            'tienes_acceso_internet' => 'nullable|boolean',
            'donde_te_conectas' => 'nullable|string',
            'tienes_computadora' => 'nullable|boolean',
            'computadora_propia_o_rentada' => 'nullable|string',
            'servicio_electricidad_estable' => 'nullable|boolean',
            'acceso_telefono_inteligente' => 'nullable|boolean',
            'espacio_para_estudiar' => 'nullable|string',
            'trabajas_actualmente' => 'nullable|boolean',
            'horas_trabajo' => 'nullable|numeric',
            'sueldo_suficiente' => 'nullable|boolean',
            'recibes_beca' => 'nullable|boolean',
        ]);

        // Si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        // Guardar los datos de la encuesta en MongoDB
        $encuesta = Encuesta::create($request->all());

        return response()->json([
            'message' => 'Encuesta guardada correctamente.',
            'encuesta' => $encuesta
        ], 201);
    }

    /**
     * Obtiene todas las encuestas.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encuestas = Encuesta::all();
        return response()->json($encuestas);
    }

    /**
     * Obtiene una encuesta específica.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $encuesta = Encuesta::find($id);

        if (!$encuesta) {
            return response()->json([
                'message' => 'Encuesta no encontrada.'
            ], 404);
        }

        return response()->json($encuesta);
    }
}
