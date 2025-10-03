<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Mostrar la vista pública del chatbot
     */
    public function index()
    {
        return view('chatbot');
    }

    /**
     * Mostrar la vista del chatbot para tutores
     */
    public function tutorChatbot()
    {
        // Asegúrate de tener esta vista en resources/views/tutor/chatbot.blade.php
        return view('tutor.chatbot');
    }

    /**
     * Procesar predicción usando la IA en Render
     */
    public function procesarPrediccion(Request $request)
    {
        // Validar la matrícula enviada
        $request->validate([
            'matricula' => 'required|string'
        ]);

        $matricula = $request->input('matricula');

        try {
            // Llamada HTTP a la API de Render
            $response = Http::post('https://ia-futured.onrender.com/predict/by_matricula', [
                'matricula' => $matricula
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'error' => 'Error en la API de Render',
                    'detalle' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo conectar con la API de Render',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
