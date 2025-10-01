<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tutor - Notificaciones</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; }
        .header { background-color: #2e7d32; color: white; padding: 10px; text-align: center; }
        .nav { background-color: #2e7d32; padding: 10px; display: flex; justify-content: center; gap: 20px; }
        .nav a { color: white; text-decoration: none; padding: 5px 10px; }
        ul { list-style: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PANEL DE TUTOR</h1>
    </div>
    <div class="nav">
        <a href="#">Inicio</a>
        <a href="#">Alumnos</a>
        <a href="#">Asesorías</a>
        <a href="#">Calendario</a>
        <a href="#">Reportes</a>
    </div>
    <div class="container">
        <h2>Notificaciones</h2>
        <ul>
            @foreach ($notificaciones as $notificacion)
                <li>
                    <span>{{ $notificacion->mensaje }}</span>
                    <small>{{ $notificacion->fecha }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>