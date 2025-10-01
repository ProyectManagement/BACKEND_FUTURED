<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

   
}