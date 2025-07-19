<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div style="text-align: center; padding: 50px;">
        <h1>Bienvenido, {{ $user->nombre }} {{ $user->app }} {{ $user->apm }}</h1>
        <p>Tu correo es: {{ $user->correo }}</p>
        <p>Tu rol es: {{ $role }}</p> <!-- Muestra el nombre del rol -->
        
        <div style="margin-top: 20px;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">
                    Cerrar sesión
                </button>
            </form>
        </div>
        
        <!-- Botón "Ir a Dashboard Alumno" -->
        <div style="margin-top: 20px;">
            <a href="{{ route('dashboard_encuestas') }}" class="btn btn-primary" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; text-decoration: none;">
                Ir a Dashboard Alumno
            </a>
        </div>
    </div>
</body>
</html>
