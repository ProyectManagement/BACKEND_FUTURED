<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Asesoria;
use App\Models\Grupo;
use App\Models\Reporte; // Asegúrate de crear este modelo
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user && optional($user->role)->nombre === 'Administrador') {
            return redirect()->route('admin.carrera.dashboard');
        }
        return redirect()->route('tutor.dashboard');
    }

    public function dashboard()
{
    $authId = auth()->id();
    $authIdObj = (is_string($authId) && preg_match('/^[a-f\d]{24}$/i', $authId)) ? new ObjectId($authId) : $authId;

    $gruposAsignados = Grupo::where(function($q) use ($authIdObj, $authId) {
        $q->where('id_tutor', $authIdObj)->orWhere('id_tutor', (string) $authId);
    })->get(['_id']);

    $grupoIdsObj = $gruposAsignados->map(function ($g) {
        return $g->_id instanceof ObjectId ? $g->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$g->_id) ? new ObjectId((string)$g->_id) : null);
    })->filter()->values()->toArray();
    $grupoIdsStr = $gruposAsignados->map(function ($g) { return (string) $g->_id; })->toArray();

    $alumnosQuery = Alumno::query();
    if (!empty($grupoIdsObj) || !empty($grupoIdsStr)) {
        $alumnosQuery->where(function($q) use ($grupoIdsObj, $grupoIdsStr) {
            if (!empty($grupoIdsObj)) { $q->whereIn('id_grupo', $grupoIdsObj); }
            if (!empty($grupoIdsStr)) { $q->orWhereIn('id_grupo', $grupoIdsStr); }
        });
    } else {
        $alumnosQuery->where(function($q) use ($authIdObj, $authId) {
            $q->where('id_users', $authIdObj)->orWhere('id_users', (string) $authId);
        });
    }
    $alumnos = $alumnosQuery->get(['_id', 'nombre', 'id_grupo', 'id_users']);
    $totalAlumnos = $alumnos->count();

    $alumnoIds = $alumnos->map(function ($a) {
        return $a->_id instanceof ObjectId ? $a->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$a->_id) ? new ObjectId((string)$a->_id) : (string)$a->_id);
    })->toArray();

    $asesorias = !empty($alumnoIds)
        ? Asesoria::whereIn('alumno_id', $alumnoIds)->get(['_id', 'alumno_id', 'fecha', 'tema'])
        : collect();

    $ahora = Carbon::now();

    // Contar asesorías futuras (programadas)
    $asesoriasActivas = $asesorias->filter(function($a) use ($ahora) {
        $fecha = is_string($a->fecha)
            ? (str_contains($a->fecha, 'T') ? Carbon::createFromFormat('Y-m-d\TH:i', $a->fecha) : Carbon::parse($a->fecha))
            : Carbon::parse($a->fecha);
        return $fecha->gte($ahora->startOfDay());
    })->count();

    // Eventos próximos (siguiente 30 días)
    $limite = Carbon::now()->addDays(30);
    $eventosProximos = $asesorias->filter(function($a) use ($ahora, $limite) {
        $fecha = is_string($a->fecha)
            ? (str_contains($a->fecha, 'T') ? Carbon::createFromFormat('Y-m-d\TH:i', $a->fecha) : Carbon::parse($a->fecha))
            : Carbon::parse($a->fecha);
        return $fecha->between($ahora, $limite);
    })->count();

    // Depuración
    \Log::info('Dashboard tutor', [
        'user_id' => auth()->id(),
        'gruposObj' => $grupoIdsObj ?? [],
        'gruposStr' => $grupoIdsStr ?? [],
        'totalAlumnos' => $totalAlumnos,
        'asesoriasActivas' => $asesoriasActivas,
        'eventosProximos' => $eventosProximos,
    ]);

    return view('tutor.dashboard', compact('totalAlumnos', 'asesoriasActivas', 'eventosProximos'));
}

    public function calendario(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $currentDate = Carbon::create($year, $month, 1);
        $currentMonth = $currentDate->format('F');
        $currentMonthNum = $currentDate->month;
        $currentYear = $currentDate->year;

        $daysInMonth = $currentDate->daysInMonth;
        $firstDayOfMonth = $currentDate->dayOfWeek;
        $calendarDays = [];
        $events = [];
        $eventsDetails = [];

        $authId = auth()->id();
        $authIdObj = (is_string($authId) && preg_match('/^[a-f\d]{24}$/i', $authId)) ? new ObjectId($authId) : $authId;

        $gruposAsignados = Grupo::where(function($q) use ($authIdObj, $authId) {
            $q->where('id_tutor', $authIdObj)->orWhere('id_tutor', (string) $authId);
        })->get(['_id']);

        $grupoIdsObj = $gruposAsignados->map(function ($g) {
            return $g->_id instanceof ObjectId ? $g->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$g->_id) ? new ObjectId((string)$g->_id) : null);
        })->filter()->values()->toArray();
        $grupoIdsStr = $gruposAsignados->map(function ($g) { return (string) $g->_id; })->toArray();

        $alumnosQuery = Alumno::query();
        if (!empty($grupoIdsObj) || !empty($grupoIdsStr)) {
            $alumnosQuery->where(function($q) use ($grupoIdsObj, $grupoIdsStr) {
                if (!empty($grupoIdsObj)) { $q->whereIn('id_grupo', $grupoIdsObj); }
                if (!empty($grupoIdsStr)) { $q->orWhereIn('id_grupo', $grupoIdsStr); }
            });
        } else {
            $alumnosQuery->where(function($q) use ($authIdObj, $authId) {
                $q->where('id_users', $authIdObj)->orWhere('id_users', (string) $authId);
            });
        }
        $alumnosIdsCollection = $alumnosQuery->get(['_id']);
        $alumnoIdsObj = $alumnosIdsCollection->map(function ($a) {
            return $a->_id instanceof ObjectId ? $a->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$a->_id) ? new ObjectId((string)$a->_id) : null);
        })->filter()->values()->toArray();
        $alumnoIdsStr = $alumnosIdsCollection->map(function ($a) { return (string) $a->_id; })->toArray();

        $asesorias = (!empty($alumnoIdsObj) || !empty($alumnoIdsStr))
            ? Asesoria::with('alumno')->where(function($q) use ($alumnoIdsObj, $alumnoIdsStr) {
                if (!empty($alumnoIdsObj)) { $q->whereIn('alumno_id', $alumnoIdsObj); }
                if (!empty($alumnoIdsStr)) { $q->orWhereIn('alumno_id', $alumnoIdsStr); }
            })->get()
            : collect();

        foreach ($asesorias as $asesoria) {
            $raw = $asesoria->fecha;
            if ($raw instanceof UTCDateTime) {
                $date = Carbon::instance($raw->toDateTime())->setTimezone(config('app.timezone', 'UTC'));
            } elseif (is_string($raw)) {
                if (str_contains($raw, 'T')) {
                    $date = Carbon::createFromFormat('Y-m-d\TH:i', $raw, 'UTC')->setTimezone(config('app.timezone', 'UTC'));
                } else {
                    $date = Carbon::parse($raw, 'UTC')->setTimezone(config('app.timezone', 'UTC'));
                }
            } else {
                $date = Carbon::parse($raw)->setTimezone(config('app.timezone', 'UTC'));
            }
            if ($date->year == $year && $date->month == $month) {
                $eventDate = $date->toDateString();
                $events[] = $eventDate;
                $alumnoNombre = $asesoria->alumno ? $asesoria->alumno->nombre . ' ' . $asesoria->alumno->apellido_paterno : null;
                $eventsDetails[] = [
                    'fecha' => $eventDate,
                    'tema' => $asesoria->tema,
                    'alumno_nombre' => $alumnoNombre,
                ];
            }
        }

        $events = array_values(array_unique($events));

        for ($i = 0; $i < $firstDayOfMonth; $i++) {
            $calendarDays[] = ['day' => '', 'date' => ''];
        }
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $currentDate->copy()->day($day)->toDateString();
            $calendarDays[] = ['day' => $day, 'date' => $date];
        }

        return view('tutor.calendario', compact('calendarDays', 'currentMonth', 'currentYear', 'currentMonthNum', 'events', 'eventsDetails'));
    }

    public function alumnos(Request $request)
    {
        $authId = auth()->id();
        $authIdObj = (is_string($authId) && preg_match('/^[a-f\d]{24}$/i', $authId)) ? new ObjectId($authId) : $authId;

        $gruposAsignados = Grupo::where(function($q) use ($authIdObj, $authId) {
            $q->where('id_tutor', $authIdObj)->orWhere('id_tutor', (string) $authId);
        })->get(['_id', 'nombre']);
        $grupoIdsObj = $gruposAsignados->map(function ($g) {
            return $g->_id instanceof ObjectId ? $g->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$g->_id) ? new ObjectId((string)$g->_id) : null);
        })->filter()->values()->toArray();
        $grupoIdsStr = $gruposAsignados->map(function ($g) { return (string) $g->_id; })->toArray();

        $grupoFiltro = $request->input('grupo');
        $query = Alumno::query()->with(['carrera', 'grupo']);

        if (!empty($grupoIdsObj) || !empty($grupoIdsStr)) {
            if ($grupoFiltro && in_array($grupoFiltro, $grupoIdsStr, true)) {
                $query->where(function($q) use ($grupoFiltro) {
                    $q->where('id_grupo', new ObjectId($grupoFiltro))
                      ->orWhere('id_grupo', (string) $grupoFiltro);
                });
            } else {
                $query->where(function($q) use ($grupoIdsObj, $grupoIdsStr) {
                    if (!empty($grupoIdsObj)) { $q->whereIn('id_grupo', $grupoIdsObj); }
                    if (!empty($grupoIdsStr)) { $q->orWhereIn('id_grupo', $grupoIdsStr); }
                });
            }
        } else {
            $query->where(function($q) use ($authIdObj, $authId) {
                $q->where('id_users', $authIdObj)->orWhere('id_users', (string) $authId);
            });
        }

        $alumnos = $query->get();

        $alumnosPorGrupo = $alumnos->groupBy(function ($alumno) {
            return optional($alumno->grupo)->nombre ?? 'Sin grupo';
        });

        return view('tutor.alumnos', compact('alumnos', 'alumnosPorGrupo', 'gruposAsignados', 'grupoFiltro'));
    }
    public function show($id)
    {
        $alumno = Alumno::with('grupo', 'carrera')->find($id);
        if (!$alumno) {
            return redirect()->route('tutor.alumnos')->with('error', 'Alumno no encontrado');
        }
        return view('tutor.alumno-detalle', compact('alumno'));
    }

    public function asesorias(Request $request)
    {
        $authId = auth()->id();
        $authIdObj = (is_string($authId) && preg_match('/^[a-f\d]{24}$/i', $authId)) ? new ObjectId($authId) : $authId;

        $gruposAsignados = Grupo::where(function($q) use ($authIdObj, $authId) {
            $q->where('id_tutor', $authIdObj)->orWhere('id_tutor', (string) $authId);
        })->get(['_id']);

        $grupoIdsObj = $gruposAsignados->map(function ($g) {
            return $g->_id instanceof ObjectId ? $g->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$g->_id) ? new ObjectId((string)$g->_id) : null);
        })->filter()->values()->toArray();
        $grupoIdsStr = $gruposAsignados->map(function ($g) { return (string) $g->_id; })->toArray();

        $alumnosQuery = Alumno::query();
        if (!empty($grupoIdsObj) || !empty($grupoIdsStr)) {
            $alumnosQuery->where(function($q) use ($grupoIdsObj, $grupoIdsStr) {
                if (!empty($grupoIdsObj)) { $q->whereIn('id_grupo', $grupoIdsObj); }
                if (!empty($grupoIdsStr)) { $q->orWhereIn('id_grupo', $grupoIdsStr); }
            });
        } else {
            $alumnosQuery->where(function($q) use ($authIdObj, $authId) {
                $q->where('id_users', $authIdObj)->orWhere('id_users', (string) $authId);
            });
        }
        $alumnos = $alumnosQuery->orderBy('nombre')->get();

        $search = trim($request->input('alumno', ''));
        $alumnosFiltrados = $alumnos;
        if ($search !== '') {
            $alumnosFiltrados = $alumnos->filter(function($alumno) use ($search) {
                $full = trim(($alumno->nombre ?? '').' '.($alumno->apellido_paterno ?? '').' '.($alumno->apellido_materno ?? ''));
                return mb_stripos($full, $search) !== false;
            });
        }

        $alumnoIdsObj = $alumnosFiltrados->map(function ($a) {
            return $a->_id instanceof ObjectId ? $a->_id : (preg_match('/^[a-f\d]{24}$/i', (string)$a->_id) ? new ObjectId((string)$a->_id) : null);
        })->filter()->values()->toArray();
        $alumnoIdsStr = $alumnosFiltrados->map(function ($a) { return (string) $a->_id; })->toArray();

        $query = Asesoria::query()->where(function($q) use ($alumnoIdsObj, $alumnoIdsStr) {
            if (!empty($alumnoIdsObj)) { $q->whereIn('alumno_id', $alumnoIdsObj); }
            if (!empty($alumnoIdsStr)) { $q->orWhereIn('alumno_id', $alumnoIdsStr); }
        });
        if ($request->has('fecha_filtro') && $request->fecha_filtro != '') {
            $query->where('fecha', '>=', $request->fecha_filtro);
        }
        $asesorias = $query->with('alumno')->get();

        return view('tutor.asesorias', compact('asesorias', 'alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required',
            'fecha' => 'required|date',
            'tema' => 'required|string|max:255',
        ]);

        $alumnoId = $request->alumno_id;
        $alumnoIdObj = (is_string($alumnoId) && preg_match('/^[a-f\d]{24}$/i', $alumnoId)) ? new ObjectId($alumnoId) : $alumnoId;

        Asesoria::create([
            'alumno_id' => $alumnoIdObj,
            'fecha' => $request->fecha,
            'tema' => $request->tema,
        ]);

        return redirect()->route('tutor.asesorias')->with('success', 'Asesoría creada exitosamente');
    }

    public function showAsesoria($id)
    {
        $asesoria = Asesoria::with('alumno')->find($id);
        if (!$asesoria) {
            return redirect()->route('tutor.asesorias')->with('error', 'Asesoría no encontrada');
        }
        return view('tutor.asesoria-detalle', compact('asesoria'));
    }

    public function reportes()
{
    // Obtener todos los reportes
    $reportes = Reporte::orderBy('created_at', 'desc')->get();
    
    // Verificar datos (para depuración)
    \Log::info('Reportes obtenidos:', ['count' => $reportes->count(), 'first' => $reportes->first()]);
    
    return view('tutor.reportes', ['reportes' => $reportes]);
}

    public function subirReporte()
    {
        return view('tutor.subir-reporte');
    }

    public function storeReporte(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:2048', // Máximo 2MB
            'compartir' => 'required|in:administrador,todos',
        ]);

        if ($request->hasFile('archivo')) {
            $filePath = $request->file('archivo')->store('reportes', 'public');
            Reporte::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'archivo' => $filePath,
                'compartido' => $request->compartir === 'todos' ? 'todos' : auth()->id(), // Compartir con todos o solo administrador
                'usuario_id' => auth()->id(), // Vincular al tutor que lo sube
            ]);
            return redirect()->route('tutor.reportes')->with('success', 'Reporte subido y compartido exitosamente');
        }

        return redirect()->back()->with('error', 'Error al subir el archivo');
    }

    public function downloadReporte($id)
    {
        $reporte = Reporte::find($id);
        if ($reporte && Storage::disk('public')->exists($reporte->archivo)) {
            return Storage::disk('public')->download($reporte->archivo);
        }
        return redirect()->back()->with('error', 'Reporte no encontrado');
    }

    public function perfil()
    {
        $user = auth()->user();
        return view('tutor.perfil', compact('user'));
    }

    public function actualizarPerfil(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'app' => 'required|string|max:255',
            'apm' => 'required|string|max:255',
            'correo' => ['required', 'email', 'unique:users,correo,' . $user->_id . ',_id'],
            'contraseña' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombre' => $request->input('nombre'),
            'app' => $request->input('app'),
            'apm' => $request->input('apm'),
            'correo' => $request->input('correo'),
        ];

        if ($request->filled('contraseña')) {
            $data['contraseña'] = Hash::make($request->input('contraseña'));
        }

        $user->update($data);

        return redirect()->route('tutor.perfil')->with('success', 'Perfil actualizado correctamente');
    }
}
