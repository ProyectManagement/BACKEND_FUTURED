<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Calendario</title>
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
            <h3 class="text-center">Calendario de Seguimientos</h3>
            @if($eventos->isEmpty())
                <div class="alert alert-success text-center" role="alert">
                    No hay eventos programados.
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Recordatorio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eventos as $evento)
                            <tr>
                                <td>{{ $evento->titulo }}</td>
                                <td>{{ $evento->fecha }}</td>
                                <td>{{ $evento->hora }}</td>
                                <td>{{ $evento->recordatorio ? 'Sí' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addEventModal">Agregar Evento</button>
            <!-- Modal para Agregar Evento -->
            <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEventModalLabel">Agregar Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="eventForm">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                                </div>
                                <div class="mb-3">
                                    <label for="hora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="hora" name="hora" required>
                                </div>
                                <div class="mb-3">
                                    <label for="recordatorio" class="form-label">Recordatorio</label>
                                    <select class="form-control" id="recordatorio" name="recordatorio" required>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div id="eventError" class="text-danger"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="addEvent()">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getCsrfToken() {
            return $('meta[name="csrf-token"]').attr('content') || '';
        }

        function addEvent() {
            const formData = $('#eventForm').serialize();
            $.ajax({
                url: '{{ route("admin.calendario") }}', // Ajusta según tu lógica de guardado
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Evento agregado exitosamente');
                    $('#addEventModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    $('#eventError').html('Error al agregar el evento: ' + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>