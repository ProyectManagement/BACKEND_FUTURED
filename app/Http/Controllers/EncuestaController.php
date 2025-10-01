<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Carrera;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use MongoDB\BSON\ObjectId;

class EncuestaController extends Controller
{
    public function showForm()
    {
        $grupos = Grupo::all();
        $carreras = Carrera::all();
        return view('encuesta', compact('grupos', 'carreras'));
    }

    public function store(Request $request)
    {
        // ✅ Validar matrícula única
        if (Encuesta::where('matricula', $request->matricula)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Matrícula ya registrada anteriormente');
        }

        // ✅ Convertir IDs a ObjectId antes de validar
        try {
            $request->merge([
                'id_carrera' => new ObjectId($request->id_carrera),
                'id_grupo' => new ObjectId($request->id_grupo),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['id_carrera' => 'ID de carrera o grupo inválido.']);
        }

        // ✅ Validación
        $validator = Validator::make($request->all(), [
            'matricula' => 'required|string|max:20',
            'correo' => 'required|email',
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'nullable|string|max:50',
            'id_carrera' => 'required|exists:carreras,_id',
            'id_grupo' => 'required|exists:grupos,_id',
            'curp' => 'required|string|size:18',
            'genero' => 'required|in:Hombre,Mujer,Otro',
            'edad' => 'required|integer|min:15|max:50',
            'telefono_celular' => 'required|string|max:15',
            'telefono_casa' => 'nullable|string|max:15',
            'direccion.calle' => 'required|string',
            'direccion.no_exterior' => 'required|string',
            'direccion.no_interior' => 'nullable|string',
            'direccion.colonia' => 'required|string',
            'direccion.cp' => 'required|string',
            'direccion.municipio' => 'required|string',
            'referencias_domicilio' => 'nullable|array',
            'servicios.luz' => 'sometimes|boolean',
            'servicios.agua' => 'sometimes|boolean',
            'servicios.internet' => 'sometimes|boolean',
            'servicios.computadora' => 'sometimes|boolean',
            'vivienda.tipo' => 'required|in:Propia,Rentada,Prestada',
            'vivienda.monto_renta' => 'nullable|numeric|min:0',
            'estado_civil' => 'required|in:Soltero,Casado,Divorciado,Viudo',
            'numero_hijos' => 'nullable|integer|min:0',
            'salud.embarazada' => [
                Rule::requiredIf($request->genero === 'Mujer'),
                'in:No,Sí'
            ],
            'salud.meses_embarazo' => 'nullable|integer|min:1|max:9',
            'salud.atencion_embarazo' => 'nullable|in:Sí,No',
            'contacto_emergencia_1.nombre' => 'required|string',
            'contacto_emergencia_1.telefono' => 'required|string',
            'contacto_emergencia_1.relacion' => 'required|string',
            'condiciones_salud.padecimiento_cronico' => 'required|in:No,Sí',
            'condiciones_salud.nombre_padecimiento' => 'nullable|string',
            'condiciones_salud.atencion_psicologica' => 'required|in:No,Sí',
            'condiciones_salud.motivo_atencion' => 'nullable|string',
            'condiciones_salud.horas_sueno' => 'required|in:<5,5-6,7-8,>8',
            'condiciones_salud.alimentacion' => 'required|in:Mala,Regular,Buena,Excelente',
            'aspectos_socioeconomicos.trabaja' => 'required|in:No,Sí',
            'aspectos_socioeconomicos.horas_trabajo' => 'nullable|integer|min:1|max:80',
            'aspectos_socioeconomicos.ingreso_mensual' => 'nullable|numeric|min:0',
            'aspectos_socioeconomicos.nombre_trabajo' => 'nullable|string',
            'aspectos_socioeconomicos.dias_trabajo' => 'nullable|string',
            'aspectos_socioeconomicos.aporte_familiar' => 'nullable|in:Padres,Pareja,Familiares,Beca,Otro',
            'aspectos_socioeconomicos.monto_aporte' => 'nullable|numeric|min:0',
            'aspectos_socioeconomicos.otro_aporte' => 'nullable|string',
            'aportantes_gasto_familiar.ingreso_familiar' => 'nullable|numeric|min:0',
            'aportantes_gasto_familiar.gasto_mensual' => 'nullable|numeric|min:0',
            'analisis_academico.promedio_previo' => 'required|numeric|min:0|max:10',
            'analisis_academico.materias_reprobadas' => 'required|integer|min:0',
            'analisis_academico.repitio_anio' => 'required|in:No,Sí',
            'analisis_academico.razon_repitio' => 'nullable|in:Problemas económicos,Problemas de salud,Dificultad académica,Problemas personales,Trabajo,Otro',
            'analisis_academico.detalle_repitio' => 'nullable|string',
            'analisis_academico.horas_estudio_diario' => 'required|in:<1,1-2,3-4,>4',
            'analisis_academico.apoyo_academico' => 'required|in:No,Sí',
            'analisis_academico.tipo_apoyo' => 'nullable|in:Tutorías,Cursos,Asesorías,Otro',
            'analisis_academico.frecuencia_apoyo' => 'nullable|in:Diario,Semanal,Quincenal,Mensual',
            'analisis_academico.motivacion' => 'required|integer|min:1|max:5',
            'analisis_academico.dificultad_estudio' => 'required|in:Tiempo,Dinero,Salud,Familia,Académica',
            'analisis_academico.expectativa_terminar' => 'required|in:Muy seguro,Seguro,Poco seguro,No seguro',
            'analisis_academico.comentarios' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '¡Por favor corrige los errores en el formulario!');
        }

        // Guardar alumno
        $alumno = Alumno::firstOrNew(['matricula' => $request->matricula]);
        $alumno->fill([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'id_carrera' => $request->id_carrera,
            'id_grupo' => $request->id_grupo,
            'curp' => $request->curp,
            'genero' => $request->genero,
            'edad' => $request->edad,
            'correo_institucional' => $request->correo,
            'telefono_celular' => $request->telefono_celular,
            'telefono_casa' => $request->telefono_casa,
            'estado_civil' => $request->estado_civil,
            'numero_hijos' => $request->numero_hijos ?? 0,
        ]);
        $alumno->save();

        // Guardar encuesta
        $encuesta = Encuesta::firstOrNew(['id_alumno' => $alumno->_id]);
        $encuesta->fill([
            'id_alumno' => $alumno->_id,
            'matricula' => $request->matricula,
            'correo' => $request->correo,
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'id_carrera' => $request->id_carrera,
            'id_grupo' => $request->id_grupo,
            'curp' => $request->curp,
            'genero' => $request->genero,
            'edad' => $request->edad,
            'telefono_celular' => $request->telefono_celular,
            'telefono_casa' => $request->telefono_casa,
            'estado_civil' => $request->estado_civil,
            'numero_hijos' => $request->numero_hijos ?? 0,
            'direccion' => $request->direccion,
            'referencias_domicilio' => $request->referencias_domicilio ?? [],
            'servicios' => [
                'luz' => $request->filled('servicios.luz'),
                'agua' => $request->filled('servicios.agua'),
                'internet' => $request->filled('servicios.internet'),
                'computadora' => $request->filled('servicios.computadora'),
            ],
            'vivienda' => $request->vivienda,
            'salud' => $request->salud,
            'contacto_emergencia_1' => $request->contacto_emergencia_1,
            'condiciones_salud' => $request->condiciones_salud,
            'aspectos_socioeconomicos' => $request->aspectos_socioeconomicos,
            'aportantes_gasto_familiar' => [
                'ingreso_familiar' => $request->input('aportantes_gasto_familiar.ingreso_familiar'),
                'gasto_mensual' => $request->input('aportantes_gasto_familiar.gasto_mensual'),
                'padre' => $request->filled('aportantes_gasto_familiar.padre'),
                'madre' => $request->filled('aportantes_gasto_familiar.madre'),
                'hermanos' => $request->filled('aportantes_gasto_familiar.hermanos'),
                'abuelos' => $request->filled('aportantes_gasto_familiar.abuelos'),
                'pareja' => $request->filled('aportantes_gasto_familiar.pareja'),
                'otro' => $request->filled('aportantes_gasto_familiar.otro'),
            ],
            'analisis_academico' => $request->analisis_academico,
        ]);
        $encuesta->save();

        return redirect()->route('encuesta.form')
            ->with('success', '¡Encuesta guardada exitosamente en MongoDB!')
            ->withInput();
    }

    // ✅ Método AJAX para obtener grupos por carrera
    public function getGruposPorCarrera($carreraId)
    {
        $grupos = Grupo::where('id_carrera', new ObjectId($carreraId))->get();
        return response()->json($grupos);
    }

    public function index()
    {
        $encuestas = Encuesta::with(['alumno', 'carrera', 'grupo'])->get();
        $encuestasPorGrupo = $encuestas->groupBy(function ($encuesta) {
            return $encuesta->grupo ? $encuesta->grupo->nombre : 'Sin Grupo';
        });

        return view('dashboard_encuestas', compact('encuestasPorGrupo'));
    }
}
