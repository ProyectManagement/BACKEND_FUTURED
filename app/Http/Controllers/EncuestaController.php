<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
use App\Models\Grupo;
use App\Models\Carrera;

class EncuestaController extends Controller
{
    public function showForm()
    {
        // Obtener todos los grupos y carreras desde MongoDB
        $grupos = Grupo::all();
        $carreras = Carrera::all();

        // Retornar la vista con los datos
        return view('encuesta', compact('grupos', 'carreras'));
    }

    public function store(Request $request)
{
    $request->validate([
        'matricula' => 'required|string',
        'nombre' => 'required|string',
        'apellido_paterno' => 'required|string',
        'apellido_materno' => 'required|string',
        'sexo' => 'required|string',
        'estado_civil' => 'required|string',
        'vive_con' => 'required|string',
        'sosten_economico' => 'required|string',
        'tipo_vivienda' => 'required|string',
        'pago_renta' => 'nullable|numeric',
        'servicios' => 'nullable|array',
        'acceso_internet' => 'required|string',
        'tiene_computadora' => 'required|string',
        'electricidad_estable' => 'required|string',
        'tipo_computadora' => 'nullable|string',
        'acceso_impresora' => 'required|string',
        'espacio_estudio' => 'required|string',
        'trabaja' => 'required|string',
        'horas_trabajo' => 'nullable|integer',
        'sueldo_suficiente' => 'required|string',
        'recibe_beca' => 'required|string',
        'considerado_abandono' => 'required|string',
        'razon_abandono' => 'nullable|string',
        'id_carrera' => 'required|string',
        'id_grupo' => 'required|string',
    ]);

    // Buscar carrera y grupo por su _id
    $carrera = Carrera::find($request->id_carrera);
    $grupo = Grupo::find($request->id_grupo);

    if (!$carrera || !$grupo) {
        return response()->json(['error' => 'Carrera o Grupo no encontrados'], 400);
    }

    // Guardar la encuesta con los datos correctos
    $encuesta = Encuesta::create([
        'matricula' => $request->matricula,
        'nombre' => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'sexo' => $request->sexo,
        'estado_civil' => $request->estado_civil,
        'vive_con' => $request->vive_con,
        'sosten_economico' => $request->sosten_economico,
        'tipo_vivienda' => $request->tipo_vivienda,
        'pago_renta' => $request->pago_renta,
        'servicios' => $request->servicios,
        'acceso_internet' => $request->acceso_internet,
        'tiene_computadora' => $request->tiene_computadora,
        'electricidad_estable' => $request->electricidad_estable,
        'tipo_computadora' => $request->tipo_computadora,
        'acceso_impresora' => $request->acceso_impresora,
        'espacio_estudio' => $request->espacio_estudio,
        'trabaja' => $request->trabaja,
        'horas_trabajo' => $request->horas_trabajo,
        'sueldo_suficiente' => $request->sueldo_suficiente,
        'recibe_beca' => $request->recibe_beca,
        'considerado_abandono' => $request->considerado_abandono,
        'razon_abandono' => $request->razon_abandono,
        'id_carrera' => $carrera->_id,
        'id_grupo' => $grupo->_id,
    ]);

    return response()->json([
        'message' => 'Encuesta guardada exitosamente',
        'data' => $encuesta
    ], 201);
}
public function index()
    {
        // Obtener todas las encuestas y cargar las relaciones con grupo y carrera
        $encuestas = Encuesta::with(['grupo', 'carrera'])->get();

        // Agrupar las encuestas por grupo
        $encuestasPorGrupo = $encuestas->groupBy(function ($encuesta) {
            return $encuesta->grupo ? $encuesta->grupo->nombre : 'Sin Grupo';
        });

        // Pasar la variable $encuestasPorGrupo a la vista
        return view('dashboard_encuestas', compact('encuestasPorGrupo'));
    }   
}