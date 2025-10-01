<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Notificaciones</title>
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
            <h3 class="text-center">Centro de Notificaciones</h3>
            <ul class="nav nav-tabs mb-3" id="notificationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="alertas-tab" data-bs-toggle="tab" data-bs-target="#alertas" type="button" role="tab" aria-controls="alertas" aria-selected="true">Alertas Automáticas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab" aria-controls="config" aria-selected="false">Configuración</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="plantillas-tab" data-bs-toggle="tab" data-bs-target="#plantillas" type="button" role="tab" aria-controls="plantillas" aria-selected="false">Plantillas</button>
                </li>
            </ul>
            <div class="tab-content" id="notificationTabsContent">
                <!-- Alertas Automáticas -->
                <div class="tab-pane fade show active" id="alertas" role="tabpanel" aria-labelledby="alertas-tab">
                    @if($notificaciones->isEmpty())
                        <div class="alert alert-success text-center" role="alert">
                            No hay alertas automáticas por el momento.
                        </div>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mensaje</th>
                                    <th>Destinatarios</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notificaciones as $notificacion)
                                    <tr>
                                        <td>{{ $notificacion->mensaje }}</td>
                                        <td>{{ $notificacion->destinatarios }}</td>
                                        <td>{{ $notificacion->fecha }}</td>
                                        <td>{{ $notificacion->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- Configuración -->
                <div class="tab-pane fade" id="config" role="tabpanel" aria-labelledby="config-tab">
                    <form id="configForm">
                        <div class="mb-3">
                            <label for="metodo" class="form-label">Método de Notificación</label>
                            <select class="form-control" id="metodo" name="metodo" required>
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="frecuencia" class="form-label">Frecuencia de Alertas</label>
                            <select class="form-control" id="frecuencia" name="frecuencia" required>
                                <option value="inmediata">Inmediata</option>
                                <option value="diaria">Diaria</option>
                                <option value="semanal">Semanal</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="saveConfig()">Guardar Configuración</button>
                        <div id="configError" class="text-danger mt-2"></div>
                    </form>
                </div>
                <!-- Plantillas -->
                <div class="tab-pane fade" id="plantillas" role="tabpanel" aria-labelledby="plantillas-tab">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Contenido</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Recordatorio de Reporte</td>
                                <td>Estimado [Nombre], recuerda subir tu reporte antes del [Fecha].</td>
                                <td><button class="btn btn-info btn-sm" onclick="editTemplate(this)">Editar</button></td>
                            </tr>
                            <tr>
                                <td>Alerta de Encuesta</td>
                                <td>Por favor, completa la encuesta antes del [Fecha].</td>
                                <td><button class="btn btn-info btn-sm" onclick="editTemplate(this)">Editar</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addTemplateModal">Agregar Plantilla</button>
                    <!-- Modal para Agregar Plantilla -->
                    <div class="modal fade" id="addTemplateModal" tabindex="-1" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addTemplateModalLabel">Agregar Plantilla</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="templateForm">
                                        <div class="mb-3">
                                            <label for="titulo" class="form-label">Título</label>
                                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contenido" class="form-label">Contenido</label>
                                            <textarea class="form-control" id="contenido" name="contenido" rows="4" required></textarea>
                                        </div>
                                        <div id="templateError" class="text-danger"></div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" onclick="addTemplate()">Agregar</button>
                                </div>
                            </div>
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

        function saveConfig() {
            const formData = $('#configForm').serialize();
            $.ajax({
                url: '{{ route("notificaciones.send") }}', // Ajusta según tu lógica de guardado
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Configuración guardada exitosamente');
                },
                error: function(xhr) {
                    $('#configError').html('Error al guardar la configuración: ' + xhr.responseText);
                }
            });
        }

        function editTemplate(button) {
            const row = button.closest('tr');
            const titulo = row.cells[0].textContent;
            const contenido = row.cells[1].textContent;
            $('#titulo').val(titulo);
            $('#contenido').val(contenido);
            $('#addTemplateModal').modal('show');
        }

        function addTemplate() {
            const formData = $('#templateForm').serialize();
            $.ajax({
                url: '{{ route("notificaciones.send") }}', // Ajusta según tu lógica de guardado
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Plantilla agregada exitosamente');
                    $('#addTemplateModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    $('#templateError').html('Error al agregar la plantilla: ' + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>