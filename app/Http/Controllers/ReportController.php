<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Reporte::all();
        return view('admin.reportes', compact('reports'));
    }

    public function store(Request $request)
    {
        Log::info('Solicitud recibida en store', $request->all());

        $validator = \Validator::make($request->all(), [
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

    public function edit($id)
    {
        $report = Reporte::find($id);
        if ($report) {
            return response()->json(['report' => $report]);
        }
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    public function update(Request $request, $id)
    {
        Log::info('Solicitud recibida en update', ['id' => $id, 'data' => $request->all()]);

        $validator = \Validator::make($request->all(), [
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
                    \Storage::delete('public/reportes/' . $report->archivo);
                    $fileName = time() . '_' . $request->file('archivo')->getClientOriginalName();
                    $request->file('archivo')->storeAs('public/reportes', $fileName);
                    $report->archivo = $fileName;
                }
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

    public function destroy($id)
    {
        $report = Reporte::find($id);
        if ($report) {
            \Storage::delete('public/reportes/' . $report->archivo);
            $report->delete();
            return response()->json(['message' => 'Reporte eliminado exitosamente']);
        }
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }

    public function share(Request $request, $id)
    {
        Log::info('Solicitud de compartir recibida', ['id' => $id]);

        $report = Reporte::find($id);
        if ($report) {
            // Lógica de compartir: aquí puedes asociar el reporte con usuarios
            // Ejemplo: Notificar a todos los usuarios con rol "Tutor"
            $tutors = \App\Models\User::whereHas('role', function ($query) {
                $query->where('nombre', 'Tutor');
            })->get();

            // Simulación de notificación (ajusta según tu sistema)
            foreach ($tutors as $tutor) {
                Log::info('Notificación enviada a', ['user' => $tutor->correo]);
            }

            // Asegurar que solo se devuelva el JSON esperado
            return response()->json(['message' => 'Reporte compartido exitosamente con tutores'], 200)->header('Content-Type', 'application/json');
        }
        return response()->json(['error' => 'Reporte no encontrado'], 404);
    }
}