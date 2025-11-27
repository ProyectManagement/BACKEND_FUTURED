<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Encuesta Routes
Route::get('/encuesta', [EncuestaController::class, 'showForm'])->name('encuesta.form');
Route::post('/encuesta', [EncuestaController::class, 'store'])->name('encuesta.store');
Route::get('/dashboard_encuestas', [EncuestaController::class, 'index'])->name('dashboard_encuestas');
Route::get('/carrera/{carrera}/grupos', [EncuestaController::class, 'getGruposPorCarrera'])->name('carrera.grupos');

// Chatbot Routes
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');
Route::post('/procesar-prediccion', [ChatbotController::class, 'procesarPrediccion']);
Route::get('/tutor/chatbot', [ChatbotController::class, 'tutorChatbot']);


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // General Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes (User Management, accessible to authenticated users)
    Route::prefix('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/grupos/{id}/asignar-tutor', [AdminController::class, 'asignarTutorGrupo'])->name('admin.grupos.asignarTutor');
    });

    // Admin Panel Routes (restricted to Administrador role)
    Route::prefix('admin')->middleware(['role:Administrador'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        
        // Rutas de Reportes
        Route::prefix('reportes')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('admin.reportes');
            Route::post('/', [ReportController::class, 'store'])->name('reportes.store');
            Route::get('/create', [ReportController::class, 'create'])->name('reportes.create');
            Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('reportes.edit');
            Route::put('/{id}', [ReportController::class, 'update'])->name('reportes.update');
            Route::delete('/{id}', [ReportController::class, 'destroy'])->name('reportes.destroy');
            Route::post('/{id}/share', [ReportController::class, 'share'])->name('reportes.share');
            Route::post('/{id}/rename', [ReportController::class, 'rename'])->name('reportes.rename');
            Route::get('/{id}/download', [ReportController::class, 'download'])->name('reportes.download');
        });

        Route::get('/grupos/asignaciones', [AdminController::class, 'gruposAsignaciones'])->name('admin.grupos.asignaciones');

        // Rutas de Auditoría de Usuarios
        Route::get('/auditoria', [AdminController::class, 'auditoria'])->name('admin.auditoria');
        
        // Rutas de Monitoreo del Chatbot
        Route::get('/chatbot', [AdminController::class, 'chatbotMonitor'])->name('admin.chatbot');
        
        // Vistas de Comunicación
        Route::get('/notificaciones', [AdminController::class, 'notificaciones'])->name('admin.notificaciones');
        Route::post('/notificaciones/send', [AdminController::class, 'sendNotification'])->name('notificaciones.send');
        Route::get('/mensajeria', [AdminController::class, 'mensajeria'])->name('admin.mensajeria');
        Route::get('/calendario', [AdminController::class, 'calendario'])->name('admin.calendario');
        
        // Vistas de Configuración Avanzada
        Route::get('/ia-config', [AdminController::class, 'iaConfig'])->name('admin.ia-config');
        Route::get('/instituciones', [AdminController::class, 'instituciones'])->name('admin.instituciones');
        Route::get('/roles', [AdminController::class, 'roles'])->name('admin.roles');
        
        // Vistas de Monitoreo y Alertas
        Route::get('/alertas', [AdminController::class, 'alertas'])->name('admin.alertas');
        Route::get('/monitoreo', [AdminController::class, 'monitoreo'])->name('admin.monitoreo');
        
        // Vistas de Recursos
        Route::get('/base-conocimiento', [AdminController::class, 'baseConocimiento'])->name('admin.base-conocimiento');
        Route::get('/recursos-intervencion', [AdminController::class, 'recursosIntervencion'])->name('admin.recursos-intervencion');
    });

    // Tutor Panel Routes
    Route::prefix('tutor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('tutor.dashboard');
        Route::get('/alumnos', [DashboardController::class, 'alumnos'])->name('tutor.alumnos');
        Route::get('/alumnos/{id}', [DashboardController::class, 'show'])->name('tutor.alumno.show');
        Route::get('/alumno-detalle/{id}', [DashboardController::class, 'show'])->name('tutor.alumno-detalle');
        Route::get('/asesorias', [DashboardController::class, 'asesorias'])->name('tutor.asesorias');
        Route::post('/asesorias', [DashboardController::class, 'store'])->name('tutor.asesorias.store');
        Route::get('/asesorias/{id}', [DashboardController::class, 'showAsesoria'])->name('tutor.asesorias.show');
        Route::patch('/asesorias/{id}/complete', [DashboardController::class, 'complete'])->name('tutor.asesorias.complete');
        Route::get('/calendario', [DashboardController::class, 'calendario'])->name('tutor.calendario');
        Route::get('/reportes', [DashboardController::class, 'reportes'])->name('tutor.reportes');
        Route::post('/reportes', [DashboardController::class, 'storeReporte'])->name('tutor.reportes.store');
        Route::get('/reportes/{id}/download', [DashboardController::class, 'downloadReporte'])->name('tutor.reportes.download');
        Route::get('/subir-reporte', [DashboardController::class, 'subirReporte'])->name('tutor.subir-reporte');
        Route::get('/notificaciones', [UserController::class, 'notificaciones'])->name('tutor.notificaciones');
        Route::get('/chatbot', [ChatbotController::class, 'tutorChatbot'])->name('tutor.chatbot');
        Route::post('/chatbot/procesar', [ChatbotController::class, 'procesarPrediccion'])->name('tutor.chatbot.procesar');
        Route::get('/perfil', [DashboardController::class, 'perfil'])->name('tutor.perfil');
        Route::post('/perfil', [DashboardController::class, 'actualizarPerfil'])->name('tutor.perfil.update');
    });
});
