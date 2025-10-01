<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Reportes</title>
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
            <h3 class="text-center">Gestión de Reportes</h3>
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#reportModal" onclick="openCreateModal()">Subir Reporte</button>
            <table class="table table-bordered">
                <thead><tr><th>Archivo</th><th>Fecha de Subida</th><th>Acciones</th></tr></thead>
                <tbody id="reportsTable">
                    @foreach ($reports as $report)
                        <tr id="report-{{ $report->_id }}">
                            <td><a href="{{ asset('storage/reportes/' . $report->archivo) }}" target="_blank">{{ $report->archivo }}</a></td>
                            <td>{{ $report->fecha }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm me-2" onclick="openEditModal('{{ $report->_id }}')">Editar</button>
                                <button class="btn btn-info btn-sm me-2" onclick="shareReport('{{ $report->_id }}')">Compartir</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteReport('{{ $report->_id }}')">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal -->
            <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportModalLabel">Subir Reporte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="reportForm" enctype="multipart/form-data">
                                <input type="hidden" id="reportId">
                                <div class="mb-3">
                                    <label for="archivo" class="form-label">Seleccionar Archivo</label>
                                    <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.xlsx,.txt" required>
                                </div>
                                <div id="errorMessages" class="text-danger"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="saveReport()">Guardar</button>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        function openCreateModal() {
            $('#reportForm')[0].reset();
            $('#reportId').val('');
            $('#reportModalLabel').text('Subir Reporte');
            $('#errorMessages').empty();
            $('#reportModal').modal('show');
        }

        function openEditModal(id) {
            $.ajax({
                url: '/admin/reportes/' + id + '/edit',
                method: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', getCsrfToken());
                },
                success: function(data) {
                    $('#reportId').val(data.report._id);
                    $('#reportModalLabel').text('Editar Reporte');
                    $('#errorMessages').empty();
                    $('#reportModal').modal('show');
                },
                error: function(xhr) {
                    alert('Error al cargar el reporte para edición: ' + xhr.responseText);
                }
            });
        }

        function saveReport() {
            const id = $('#reportId').val();
            const url = id ? '/admin/reportes/' + id : '/admin/reportes';
            const method = id ? 'PUT' : 'POST';
            const formData = new FormData($('#reportForm')[0]);

            formData.append('_token', getCsrfToken());

            console.log('Enviando solicitud a:', url);
            console.log('Método:', method);
            console.log('Datos:', formData);

            if (!$('#archivo')[0].files.length) {
                $('#errorMessages').html('<p>Por favor, selecciona un archivo.</p>');
                return;
            }

            $.ajax({
                url: url,
                method: method,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', getCsrfToken());
                },
                success: function(response) {
                    alert('Reporte guardado exitosamente.');
                    $('#reportModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                    const errors = xhr.responseJSON?.errors || { general: ['Error desconocido'] };
                    let errorHtml = '';
                    for (let key in errors) {
                        errorHtml += `<p>${errors[key][0]}</p>`;
                    }
                    $('#errorMessages').html(errorHtml);
                }
            });
        }

        function shareReport(id) {
            if (!confirm('¿Estás seguro de compartir este reporte con otros usuarios?')) {
                return;
            }
            $.ajax({
                url: '/admin/reportes/' + id + '/share',
                method: 'POST',
                data: { report_id: id, _token: getCsrfToken() },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', getCsrfToken());
                },
                success: function(response) {
                    if (response && response.message) {
                        alert(response.message); // Muestra el mensaje devuelto por el servidor
                    } else {
                        alert('Reporte compartido exitosamente.');
                    }
                },
                error: function(xhr) {
                    console.log('Error en la solicitud:', xhr.status, xhr.responseText);
                    let errorMessage = 'Error al compartir el reporte';
                    try {
                        // Intentar parsear la respuesta como JSON para extraer el mensaje
                        let responseText = xhr.responseText.replace(/^\s*\/\/\s*/, ''); // Eliminar el // inicial
                        let jsonResponse = JSON.parse(responseText);
                        if (jsonResponse && jsonResponse.message) {
                            alert(jsonResponse.message); // Mostrar el mensaje si está presente
                            return;
                        }
                    } catch (e) {
                        console.log('No se pudo parsear la respuesta como JSON:', e);
                    }
                    alert(errorMessage + (xhr.responseText ? ': ' + xhr.responseText : ''));
                }
            });
        }

        function deleteReport(id) {
            if (!confirm('¿Estás seguro de eliminar este reporte? Esta acción no se puede deshacer.')) {
                return;
            }
            $.ajax({
                url: '/admin/reportes/' + id,
                method: 'DELETE',
                data: { _token: getCsrfToken() },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', getCsrfToken());
                },
                success: function(response) {
                    $('#report-' + id).remove();
                },
                error: function(xhr) {
                    alert('Error al eliminar el reporte: ' + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>