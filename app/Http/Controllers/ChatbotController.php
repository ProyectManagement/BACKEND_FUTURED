<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    // Chatbot público
    public function index()
    {
        return view('chatbot');
    }

    // Chatbot para tutores (nuevo método)
    public function tutorChatbot()
    {
        return view('tutor.chatbot'); // Asegúrate de tener esta vista
    }

    // Método de procesamiento (compartido pero protegido para tutores)
    public function procesarPrediccion(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string'
        ]);


        $matricula = $request->input('matricula');
        $scriptPath = base_path('../IA-IA/prediccion_alumno.py');

        if (!file_exists($scriptPath)) {
            return response()->json([
                'error' => "El script no se encontró en: $scriptPath",
                'tipo' => 'ruta_invalida'
            ], 500);
        }

        $command = escapeshellcmd("python \"$scriptPath\" \"$matricula\"");
        exec($command, $output, $status);

        if ($status !== 0) {
            return response()->json([
                'error' => "Error al ejecutar el script de predicción.",
                'tipo' => 'script_error',
                'detalle' => $output,
                'codigo_salida' => $status
            ], 500);
        }

        $resultado = [];
        foreach ($output as $line) {
            $parts = explode(':', $line, 2);
            if (count($parts) == 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                $resultado[$key] = $value;
            }
        }

        return response()->json($resultado);
    }
}