<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - ChatBot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .nav-link.active { background-color: #28a745; color: white !important; }
        .card-custom { border: none; text-align: center; padding: 20px; margin: 10px; }
        .card-custom.blue { background-color: #007bff; }
        .card-custom.green { background-color: #28a745; }
        .card-custom.yellow { background-color: #ffc107; }
        .card-custom.red { background-color: #dc3545; }
        .card-custom { color: white; }
        .navbar-nav { flex-grow: 1; }
        .logout-form { margin-left: auto; }
        @media (max-width: 992px) {
            .logout-form { width: 100%; margin-top: 10px; }
            .logout-form button { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="bg-success text-white p-2 text-center">PANEL DE ADMINISTRADOR</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.index') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.reportes') }}">Reportes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.chatbot') }}">Chatbot</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.calendario') }}">Calendario</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.notificaciones') }}">Notificaciones</a></li>
                    </ul>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="content">
            <h3 class="text-center">Monitoreo del Chatbot</h3>
            @if($interacciones->isEmpty())
                <div class="alert alert-success text-center" role="alert">
                    No hay interacciones registradas por el momento.
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Pregunta</th>
                            <th>Respuesta</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interacciones as $interaccion)
                            <tr>
                                <td>{{ $interaccion->fecha }}</td>
                                <td>{{ $interaccion->pregunta }}</td>
                                <td>{{ $interaccion->respuesta }}</td>
                                <td>{{ $interaccion->estado }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>