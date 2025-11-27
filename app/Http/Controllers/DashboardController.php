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

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('tutor.dashboard');
    }

   public function dashboard()
{
    // Número total de alumnos asignados al tutor
    $totalAlumnos = Alumno::where('id_users', auth()->id())->count();

    // Obtener IDs de alumnos asignados al tutor
    $alumnoIds = Alumno::where('id_users', auth()->id())
        ->get()
        ->map(function ($alumno) {
            return (string) $alumno->_id;
        })->toArray();

    // Número de asesorías programadas (futuras)
    $asesoriasActivas = Asesoria::whereIn('alumno_id', $alumnoIds)
        ->whereRaw(['fecha' => ['$gte' => Carbon::now()->startOfDay()->toDateTimeString()]])
        ->count();

    // Depuración
    \Log::info('Dashboard debug', [
        'user_id' => auth()->id(),
        'totalAlumnos' => $totalAlumnos,
        'alumnoIds' => $alumnoIds,
        'alumnos' => Alumno::where('id_users', auth()->id())->get(['_id', 'nombre', 'id_users'])->toArray(),
        'asesorias' => Asesoria::whereIn('alumno_id', $alumnoIds)
            ->whereRaw(['fecha' => ['$gte' => Carbon::now()->startOfDay()->toDateTimeString()]])
            ->get()->toArray(),
    ]);

    return view('tutor.dashboard', compact('totalAlumnos', 'asesoriasActivas'));
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

        $asesorias = Asesoria::with('alumno')->get();
        $eventsDetails = [];
        $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);
        foreach ($asesorias as $asesoria) {
            if (is_string($asesoria->fecha)) {
                $date = Carbon::createFromFormat('Y-m-d\TH:i', $asesoria->fecha);
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
            } else {
                $date = Carbon::parse($asesoria->fecha);
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
        }

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
        $gruposAsignados = Grupo::where('id_tutor', auth()->id())->get(['_id', 'nombre']);
        $grupoIds = $gruposAsignados->map(fn($g) => (string)$g->_id)->toArray();

        $grupoFiltro = $request->input('grupo');
        $query = Alumno::query()->with(['carrera', 'grupo']);

        if (!empty($grupoIds)) {
            if ($grupoFiltro && in_array($grupoFiltro, $grupoIds, true)) {
                $query->where('id_grupo', $grupoFiltro);
            } else {
                $query->whereIn('id_grupo', $grupoIds);
            }
        } else {
            $query->where('id_users', auth()->id());
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
        $query = Asesoria::query();

        if ($request->has('fecha_filtro') && $request->fecha_filtro != '') {
            $query->where('fecha', '>=', $request->fecha_filtro);
        }

        $asesorias = $query->with('alumno')->get();
        $alumnos = Alumno::all();
        return view('tutor.asesorias', compact('asesorias', 'alumnos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required',
            'fecha' => 'required|date',
            'tema' => 'required|string|max:255',
        ]);

        Asesoria::create([
            'alumno_id' => $request->alumno_id,
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
