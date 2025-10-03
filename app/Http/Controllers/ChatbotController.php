<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Usaremos HTTP client de Laravel

class ChatbotController extends Controller
{
    // Mostrar la vista del chatbot
    public function index()
    {
        return view('chatbot'); // tu Blade principal
    }

    // Método para procesar predicción vía IA en Render
    public function procesarPrediccion(Request $request)
    {
        $request->validate([
            'matricula' => 'required|string'
        ]);

        $matricula = $request->input('matricula');

        try {
            $response = Http::post('https://ia-futured.onrender.com/predict/by_matricula', [
                'matricula' => $matricula
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'error' => 'Error desde la API de IA',
                    'detalle' => $response->body()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo conectar con la API de IA',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
