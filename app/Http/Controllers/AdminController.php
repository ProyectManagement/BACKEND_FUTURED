<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Asesoria;
use App\Models\Prediccion;
use App\Models\Encuesta;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Grupo;
use App\Models\Role;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $reportCount = Reporte::count();
        $pendingCount = 0; // Ajusta según tu lógica
        $messageCount = 0; // Ajusta según tu lógica

        return view('admin.index', compact('userCount', 'reportCount', 'pendingCount', 'messageCount'));
    }

    public function reportes()
    {
        $reports = Reporte::all();
        return view('admin.reportes', compact('reports'));
    }

    public function reportesStore(Request $request)
    {
        Log::info('Solicitud recibida en reportesStore', $request->all());

        $validator = Validator::make($request->all(), [
            'nombre_archivo' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,doc,docx,xlsx,txt|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('Validación fallida', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $fileName = time() . '_' . $request->file('archivo')->getClientOriginalName();
            $request->file('archivo')->storeAs('public/reportes', $fileName);

            Reporte::create([
                'nombre_archivo' => $request->nombre_archivo,
                'archivo' => $fileName,
                'fecha' => now()->toDateString(),
            ]);

            Log::info('Reporte guardado exitosamente', ['file' => $fileName]);
            return response()->json(['message' => 'Reporte subido exitosamente']);
        } catch (\Exception $e) {
            Log::error('Error al guardar el reporte', ['message' => $e->getMessage()]);
            return response()->json(['errors' => ['general' => ['Error al guardar el archivo.']]], 500);
        }
    }

    public function reportesEdit($id)
    {
        $report = Reporte::find($id);
        if ($report) {
            return response()->json(['report' => $report]);
        }
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    public function reportesUpdate(Request $request, $id)
    {
        Log::info('Solicitud recibida en reportesUpdate', $request->all());
        $validator = Validator::make($request->all(), [
            'nombre_archivo' => 'required|string|max:255',
            'archivo' => 'file|mimes:pdf,doc,docx,xlsx,txt|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('Validación fallida', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $report = Reporte::find($id);
            if ($report) {
                if ($request->hasFile('archivo')) {
                    Storage::delete('public/reportes/' . $report->archivo);
                    $fileName = time() . '_' . $request->file('archivo')->getClientOriginalName();
                    $request->file('archivo')->storeAs('public/reportes', $fileName);
                    $report->archivo = $fileName;
                }
                $report->nombre_archivo = $request->nombre_archivo;
                $report->fecha = now()->toDateString();
                $report->save();

                Log::info('Reporte actualizado exitosamente', ['id' => $id]);
                return response()->json(['message' => 'Reporte actualizado exitosamente']);
            }
            return response()->json(['error' => 'Reporte no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el reporte', ['message' => $e->getMessage()]);
            return response()->json(['errors' => ['general' => ['Error al actualizar el archivo.']]], 500);
        }
    }

    public function reportesDestroy($id)
    {
        $report = Reporte::find($id);
        if ($report) {
            Storage::delete('public/reportes/' . $report->archivo);
            $report->delete();
            return response()->json(['message' => 'Reporte eliminado exitosamente']);
        }
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    public function reportesShare(Request $request, $id)
    {
        Log::info('Solicitud de compartir recibida', ['id' => $id]);

        $report = Reporte::find($id);
        if ($report) {
            $tutors = User::whereHas('role', function ($query) {
                $query->where('nombre', 'Tutor');
            })->get();

            foreach ($tutors as $tutor) {
                Log::info('Notificación enviada a', ['user' => $tutor->correo]);
            }

            return response()->json(['message' => 'Reporte compartido exitosamente con tutores']);
        }
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    public function chatbotMonitor()
    {
        $interacciones = collect([
            (object)['id' => 1, 'fecha' => now()->toDateString(), 'pregunta' => '¿Cuándo es el examen?', 'respuesta' => 'El examen es el 25/07/2025', 'estado' => 'Resuelta'],
            (object)['id' => 2, 'fecha' => now()->toDateString(), 'pregunta' => '¿Cómo subir un reporte?', 'respuesta' => 'En construcción', 'estado' => 'Necesita Revisión'],
        ]);
        return view('admin.chatbot', compact('interacciones'));
    }

    // Vistas de Comunicación
    public function notificaciones()
    {
        $notificaciones = collect([]); // Historial simulado, ajusta según tu modelo
        return view('admin.notificaciones', compact('notificaciones'));
    }

    public function sendNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destinatarios' => 'required|in:todos,tutores,estudiantes',
            'mensaje' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $destinatarios = $request->input('destinatarios');
        $mensaje = $request->input('mensaje');
        $users = User::whereHas('role', function ($query) use ($destinatarios) {
            if ($destinatarios === 'tutores') $query->where('nombre', 'Tutor');
            elseif ($destinatarios === 'estudiantes') $query->where('nombre', 'Estudiante');
        })->orWhere('role', 'todos')->get();
        foreach ($users as $user) {
            Log::info('Notificación enviada a', ['user' => $user->correo, 'mensaje' => $mensaje]);
        }
        return response()->json(['message' => 'Notificación enviada exitosamente']);
    }

    public function mensajeria()
    {
        $mensajes = collect([
            (object)['id' => 1, 'remitente' => 'Juan Pérez', 'destinatario' => 'María López', 'mensaje' => 'Reunión a las 2 PM', 'fecha' => now()->toDateTimeString()],
            (object)['id' => 2, 'remitente' => 'María López', 'destinatario' => 'Juan Pérez', 'mensaje' => 'Confirmado', 'fecha' => now()->toDateTimeString()],
        ]);
        return view('admin.mensajeria', compact('mensajes'));
    }

    public function calendario()
    {
        $eventos = collect([
            (object)['id' => 1, 'titulo' => 'Revisión de Reportes', 'fecha' => '2025-07-25', 'hora' => '10:00', 'recordatorio' => true],
            (object)['id' => 2, 'titulo' => 'Reunión con Tutores', 'fecha' => '2025-07-26', 'hora' => '14:00', 'recordatorio' => false],
        ]);
        return view('admin.calendario', compact('eventos'));
    }

    // Vistas de Configuración Avanzada
    public function iaConfig()
    {
        $config = ['parametro1' => 'valor1', 'parametro2' => 'valor2']; // Simulación, ajusta según tu IA
        return view('admin.ia-config', compact('config'));
    }

    public function instituciones()
    {
        $instituciones = collect([
            (object)['id' => 1, 'nombre' => 'Universidad A', 'ubicacion' => 'Ciudad X', 'config' => 'Configuración 1'],
            (object)['id' => 2, 'nombre' => 'Universidad B', 'ubicacion' => 'Ciudad Y', 'config' => 'Configuración 2'],
        ]);
        return view('admin.instituciones', compact('instituciones'));
    }

    public function roles()
    {
        $users = User::with('roles')->get();
        return view('admin.roles', compact('users'));
    }

    public function gruposAsignaciones()
    {
        $grupos = Grupo::with(['carrera', 'tutor'])->get();
        $roleTutor = Role::where('nombre', 'Tutor')->first();
        $tutores = $roleTutor ? User::where('id_rol', $roleTutor->_id)->get() : collect();
        return view('admin.grupos-asignar', compact('grupos', 'tutores'));
    }

    public function asignarTutorGrupo(Request $request, $grupoId)
    {
        $request->validate([
            'tutor_id' => 'required|exists:users,_id',
        ]);

        $grupo = Grupo::find($grupoId);
        if (!$grupo) {
            return redirect()->back()->with('error', 'Grupo no encontrado');
        }

        $grupo->id_tutor = $request->input('tutor_id');
        $grupo->save();

        return redirect()->back()->with('success', 'Tutor asignado al grupo');
    }

    // =============================
    // Panel Directivo de Carrera
    // =============================

    public function carreraDashboard(Request $request)
    {
        $carreraId = $request->input('carrera_id');

        $carreras = Carrera::all(['_id', 'nombre']);
        $alumnosQuery = Alumno::query();
        $gruposQuery = Grupo::query();
        $encuestasQuery = Encuesta::query();

        if ($carreraId) {
            $alumnosQuery->where('id_carrera', $carreraId);
            $gruposQuery->where('id_carrera', $carreraId);
            $encuestasQuery->where('id_carrera', $carreraId);
        }

        $alumnos = $alumnosQuery->with('grupo')->get();
        $totalEstudiantes = $alumnos->count();

        // Distribución por grupo
        $distribucionGrupo = $alumnos->groupBy(function ($alumno) {
            return optional($alumno->grupo)->nombre ?? 'Sin grupo';
        })->map->count()->sortDesc();

        // Niveles de atención basados en la última predicción
        // Intentar cruzar por matrícula y si no hay resultados, por id_alumno
        $matriculas = $alumnos->pluck('matricula')->filter()->values()->toArray();
        $predPorMatricula = !empty($matriculas)
            ? Prediccion::whereIn('matricula', $matriculas)->orderBy('fecha', 'desc')->get()
            : collect();

        $alumnoIds = $alumnos->map(fn($a) => (string)$a->_id)->toArray();
// Construir ObjectId solo para cadenas válidas (24 hex) y evitar errores con UUIDs
$objectIds = [];
foreach ($alumnoIds as $s) {
    if (is_string($s) && preg_match('/^[a-f0-9]{24}$/i', $s)) {
        try { $objectIds[] = new ObjectId($s); } catch (\Throwable $e) { /* ignorar inválidos */ }
    }
}
        $predPorIdObj = !empty($objectIds)
            ? Prediccion::whereIn('id_alumno', $objectIds)->orderBy('fecha', 'desc')->get()
            : collect();
        $predPorIdStr = !empty($alumnoIds)
            ? Prediccion::whereIn('id_alumno', $alumnoIds)->orderBy('fecha', 'desc')->get()
            : collect();

        $usarMatricula = $predPorMatricula->count() > 0;
        $predBase = $usarMatricula ? $predPorMatricula : ($predPorIdObj->count() > 0 ? $predPorIdObj : $predPorIdStr);
        $ultimaPorClave = $predBase
            ->groupBy($usarMatricula ? 'matricula' : 'id_alumno')
            ->map(function ($items) {
                return $items->sortByDesc('fecha')->first();
            });

        // Categorías por umbral numérico de riesgo
        $categorias = [
            'alto' => [
                'label' => 'Alto riesgo',
                'count' => 0,
                'motivo' => 'Alto riesgo: múltiples factores académicos y personales',
                'recomendacion' => 'Asesoría académica urgente y apoyo psicológico',
            ],
            'medio' => [
                'label' => 'Riesgo medio',
                'count' => 0,
                'motivo' => 'Riesgo medio: bajo promedio o problemas personales',
                'recomendacion' => 'Tutoría y monitoreo continuo',
            ],
            'leve' => [
                'label' => 'Riesgo leve',
                'count' => 0,
                'motivo' => 'Riesgo leve: dificultad para estudiar o motivación baja',
                'recomendacion' => 'Seguimiento por tutor y actividades motivacionales',
            ],
            'sin' => [
                'label' => 'Sin riesgo aparente',
                'count' => 0,
                'motivo' => 'Sin riesgo aparente',
                'recomendacion' => 'Mantener seguimiento regular',
            ],
        ];

        foreach ($ultimaPorClave as $pred) {
            $valor = $pred->riesgo ?? null;
            // Convertir textual a aproximación numérica si aplica
            if (!is_null($valor) && !is_numeric($valor)) {
                $v = strtolower((string)$valor);
                if (in_array($v, ['alto', 'critico', 'crítico'], true)) $valor = 80;
                elseif (in_array($v, ['medio', 'seguimiento'], true)) $valor = 60;
                elseif (in_array($v, ['leve', 'bajo', 'normal'], true)) $valor = 40;
                else $valor = 0;
            }

            $num = is_numeric($valor) ? floatval($valor) : 0;
            if ($num >= 80) $categorias['alto']['count']++;
            elseif ($num >= 60) $categorias['medio']['count']++;
            elseif ($num >= 40) $categorias['leve']['count']++;
            else $categorias['sin']['count']++;
        }

        // Porcentajes por categoría
        foreach ($categorias as $key => $cat) {
            $categorias[$key]['percent'] = $totalEstudiantes > 0 ? round(100 * ($cat['count'] / $totalEstudiantes), 1) : 0;
        }

        // Riesgo por grupo
        $riesgoPorGrupo = [];
        foreach ($alumnos as $alumno) {
            $grupoNombre = optional($alumno->grupo)->nombre ?? 'Sin grupo';
            if (!isset($riesgoPorGrupo[$grupoNombre])) {
                $riesgoPorGrupo[$grupoNombre] = [
                    'alto' => 0,
                    'medio' => 0,
                    'leve' => 0,
                    'sin' => 0,
                    'total' => 0,
                ];
            }

            $clave = $usarMatricula ? (string)($alumno->matricula ?? '') : (string)$alumno->_id;
            $pred = $ultimaPorClave->get($clave);
            $valor = $pred->riesgo ?? null;
            if (!is_null($valor) && !is_numeric($valor)) {
                $v = strtolower((string)$valor);
                if (in_array($v, ['alto', 'critico', 'crítico'], true)) $valor = 80;
                elseif (in_array($v, ['medio', 'seguimiento'], true)) $valor = 60;
                elseif (in_array($v, ['leve', 'bajo', 'normal'], true)) $valor = 40;
                else $valor = 0;
            }
            $num = is_numeric($valor) ? floatval($valor) : 0;

            if ($num >= 80) $riesgoPorGrupo[$grupoNombre]['alto']++;
            elseif ($num >= 60) $riesgoPorGrupo[$grupoNombre]['medio']++;
            elseif ($num >= 40) $riesgoPorGrupo[$grupoNombre]['leve']++;
            else $riesgoPorGrupo[$grupoNombre]['sin']++;
            $riesgoPorGrupo[$grupoNombre]['total']++;
        }

        // Ordenar por total descendente para una lectura más clara
        uksort($riesgoPorGrupo, function($a, $b) use ($riesgoPorGrupo) {
            return $riesgoPorGrupo[$b]['total'] <=> $riesgoPorGrupo[$a]['total'];
        });

        // Tasa de retención aproximada usando encuestas (considerado_abandono)
        $encuestas = $encuestasQuery->get(['considerado_abandono']);
        $totalEncuestas = $encuestas->count();
        $abandono = $encuestas->filter(function ($e) {
            $val = strtolower((string)($e->considerado_abandono ?? 'no'));
            return in_array($val, ['si', 'sí', 'true', '1'], true);
        })->count();
        $retencionActual = $totalEncuestas > 0 ? round(100 * (1 - ($abandono / $totalEncuestas)), 1) : null;

        // Comparativa simple: estimación del mes anterior
        $comparativa = null;
        if ($retencionActual !== null) {
            $comparativa = [
                'anterior' => max(min($retencionActual + (mt_rand(-5, 5) / 10), 100), 0),
                'actual' => $retencionActual,
            ];
        }

        return view('admin.carrera.dashboard', compact(
            'carreras', 'carreraId', 'totalEstudiantes', 'distribucionGrupo', 'categorias', 'retencionActual', 'comparativa', 'riesgoPorGrupo'
        ));
    }

    public function carreraTutores(Request $request)
    {
        $carreraId = $request->input('carrera_id');
        $carreras = Carrera::all(['_id', 'nombre']);

        $roleTutor = Role::where('nombre', 'Tutor')->first();
        $tutores = $roleTutor ? User::where('id_rol', $roleTutor->_id)->get(['_id', 'nombre', 'app', 'apm', 'correo']) : collect();

        // Grupos de la carrera
        $grupos = $carreraId ? Grupo::where('id_carrera', $carreraId)->get(['_id', 'nombre', 'id_tutor']) : Grupo::all(['_id', 'nombre', 'id_tutor']);
        $grupoIds = $grupos->map(fn($g) => (string)$g->_id)->toArray();

        // Alumnos por grupo
        $alumnos = !empty($grupoIds)
            ? Alumno::whereIn('id_grupo', $grupoIds)->get(['_id', 'id_grupo', 'id_users'])
            : collect();

        // Métricas por tutor
        $porTutor = [];
        foreach ($tutores as $tutor) {
            $alumnosTutor = $alumnos->filter(fn($a) => (string)$a->id_users === (string)$tutor->_id);
            $alumnoIds = $alumnosTutor->map(fn($a) => (string)$a->_id)->toArray();
            $asesoriasCount = !empty($alumnoIds) ? Asesoria::whereIn('alumno_id', $alumnoIds)->count() : 0;

            // Casos pendientes: al menos un crítico. Preferir cruce por matrícula
            $matriculasTutor = $alumnosTutor->pluck('matricula')->filter()->values()->toArray();
            $predPorMatricula = !empty($matriculasTutor) ? Prediccion::whereIn('matricula', $matriculasTutor)->orderBy('fecha', 'desc')->get() : collect();
// Construir ObjectId de alumnos del tutor solo para IDs válidos
$objectIdsTutor = [];
foreach ($alumnoIds as $s) {
    if (is_string($s) && preg_match('/^[a-f0-9]{24}$/i', $s)) {
        try { $objectIdsTutor[] = new ObjectId($s); } catch (\Throwable $e) { /* ignorar inválidos */ }
    }
}
            $predPorIdObj = !empty($objectIdsTutor) ? Prediccion::whereIn('id_alumno', $objectIdsTutor)->orderBy('fecha', 'desc')->get() : collect();
            $predPorIdStr = !empty($alumnoIds) ? Prediccion::whereIn('id_alumno', $alumnoIds)->orderBy('fecha', 'desc')->get() : collect();
            $usarMatriculaTutor = $predPorMatricula->count() > 0;
            $predBaseTutor = $usarMatriculaTutor ? $predPorMatricula : ($predPorIdObj->count() > 0 ? $predPorIdObj : $predPorIdStr);
            $ultima = $predBaseTutor
                ->groupBy($usarMatriculaTutor ? 'matricula' : 'id_alumno')
                ->map(fn($items) => $items->sortByDesc('fecha')->first());
            $tienePendientes = $ultima->contains(function ($p) {
                return $this->mapNivelAtencion($p->riesgo ?? null) === 'critico';
            });

            $porTutor[] = [
                'tutor' => $tutor,
                'estudiantes' => $alumnosTutor->count(),
                'asesorias' => $asesoriasCount,
                'pendientes' => $tienePendientes,
            ];
        }

        // Carga balanceada: media y desviación simple aproximada
        $promedio = count($porTutor) > 0 ? round(array_sum(array_map(fn($t) => $t['estudiantes'], $porTutor)) / count($porTutor), 1) : 0;

        return view('admin.carrera.tutores', compact('carreras', 'carreraId', 'porTutor', 'promedio'));
    }

    public function carreraEstudiantes(Request $request)
    {
        $carreraId = $request->input('carrera_id');
        $grupoId = $request->input('grupo_id');
        $tutorId = $request->input('tutor_id');
        $q = trim((string)$request->input('q'));
        $hasFilters = ($carreraId || $grupoId || $tutorId || $q !== '');

        $carreras = Carrera::all(['_id', 'nombre']);
        $grupos = $carreraId ? Grupo::where('id_carrera', $carreraId)->get(['_id', 'nombre']) : Grupo::all(['_id', 'nombre']);
        $roleTutor = Role::where('nombre', 'Tutor')->first();
        $tutores = $roleTutor ? User::where('id_rol', $roleTutor->_id)->get(['_id', 'nombre', 'app', 'apm']) : collect();

        // Si no hay filtros, devolvemos listado vacío para que la página cargue sin resultados
        if (!$hasFilters) {
            return view('admin.carrera.estudiantes', [
                'carreras' => $carreras,
                'grupos' => $grupos,
                'tutores' => $tutores,
                'carreraId' => $carreraId,
                'grupoId' => $grupoId,
                'tutorId' => $tutorId,
                'riesgoFiltro' => null,
                'q' => $q,
                'listado' => collect(),
                'hasFilters' => false,
            ]);
        }

        $query = Alumno::query()->with(['carrera', 'grupo.tutor', 'user']);
        if ($carreraId) $query->where('id_carrera', $carreraId);
        if ($grupoId) $query->where('id_grupo', $grupoId);
        if ($tutorId) $query->where('id_users', $tutorId);

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->orWhere('nombre', 'like', "%$q%")
                    ->orWhere('apellido_paterno', 'like', "%$q%")
                    ->orWhere('apellido_materno', 'like', "%$q%")
                    ->orWhere('matricula', 'like', "%$q%");
            });
        }

        $alumnos = $query->get();

        // Enriquecer solo con riesgo, preferir matrícula
        $matriculas = $alumnos->pluck('matricula')->filter()->values()->toArray();
        $predPorMatricula = !empty($matriculas) ? Prediccion::whereIn('matricula', $matriculas)->orderBy('fecha', 'desc')->get() : collect();
        $alumnoIds = $alumnos->map(fn($a) => (string)$a->_id)->toArray();
// Construir ObjectId solo si el formato es válido (24 hex)
$objectIds = [];
foreach ($alumnoIds as $s) {
    if (is_string($s) && preg_match('/^[a-f0-9]{24}$/i', $s)) {
        try { $objectIds[] = new ObjectId($s); } catch (\Throwable $e) { /* ignorar inválidos */ }
    }
}
        $predPorIdObj = !empty($objectIds) ? Prediccion::whereIn('id_alumno', $objectIds)->orderBy('fecha', 'desc')->get() : collect();
        $predPorIdStr = !empty($alumnoIds) ? Prediccion::whereIn('id_alumno', $alumnoIds)->orderBy('fecha', 'desc')->get() : collect();
        $usarMatricula = $predPorMatricula->count() > 0;
        $predBase = $usarMatricula ? $predPorMatricula : ($predPorIdObj->count() > 0 ? $predPorIdObj : $predPorIdStr);
        $ultimaPred = $predBase
            ->groupBy($usarMatricula ? 'matricula' : 'id_alumno')
            ->map(fn($items) => $items->sortByDesc('fecha')->first());

        $listado = $alumnos->map(function ($a) use ($ultimaPred, $usarMatricula) {
            $clave = $usarMatricula ? (string)($a->matricula ?? '') : (string)$a->_id;
            $riesgo = $this->mapNivelAtencion(optional($ultimaPred->get($clave))->riesgo ?? null);
            return [
                'alumno' => $a,
                'riesgo' => $riesgo,
            ];
        });

        return view('admin.carrera.estudiantes', [
            'carreras' => $carreras,
            'grupos' => $grupos,
            'tutores' => $tutores,
            'carreraId' => $carreraId,
            'grupoId' => $grupoId,
            'tutorId' => $tutorId,
            'riesgoFiltro' => null,
            'q' => $q,
            'listado' => $listado,
            'hasFilters' => true,
        ]);
    }

    private function mapNivelAtencion($valor)
    {
        // Legacy textual mapping
        $v = strtolower((string)$valor);
        if (is_numeric($valor)) {
            $num = floatval($valor);
            if ($num >= 80) return 'critico';
            if ($num >= 60) return 'seguimiento';
            return 'normal';
        }
        if (in_array($v, ['alto', 'critico', 'crítico'], true)) return 'critico';
        if (in_array($v, ['medio', 'seguimiento'], true)) return 'seguimiento';
        if (in_array($v, ['leve', 'bajo', 'normal'], true)) return 'normal';
        return 'normal';
    }
}
