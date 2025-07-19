<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        // Obtener todos los alumnos clasificados por grupo
        $alumnosPorGrupo = Alumno::with(['grupo', 'carrera'])->get()->groupBy(function($alumno) {
            return $alumno->grupo ? $alumno->grupo->nombre : 'Sin Grupo';
        });

        return view('dashboard_alumnos', compact('alumnosPorGrupo'));
    }
}
