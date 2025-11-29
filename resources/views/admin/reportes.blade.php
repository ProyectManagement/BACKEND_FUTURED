<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Reportes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --green:#22c55e; --green-dark:#16a34a; --text:#0b1321; --muted:#475569; --border:#e2e8f0; }
        *{box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;background:#f8fafc;min-height:100vh;color:var(--text)}
        .main-header{background:#fff;border-bottom:1px solid var(--border);padding:1rem 0;position:sticky;top:0;z-index:1000;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .header-title{font-weight:800;font-size:1.8rem;margin:0;color:var(--text)}
        .header-subtitle{color:var(--muted);font-size:.95rem;margin:0}
        .nav-pills .nav-link{color:var(--text);background:#f1f5f9;border-radius:999px;padding:.7rem 1.2rem;margin:0 .25rem;font-weight:600;border:1px solid var(--border)}
        .nav-pills .nav-link:hover{background:#e2fbe8;border-color:#bbf7d0;color:#166534}
        .nav-pills .nav-link.active{background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;border-color:transparent}
        .account-btn{background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;border:none;padding:.6rem 1.2rem;border-radius:12px;font-weight:700}
        .account-btn:focus{box-shadow:0 0 0 .25rem rgba(34,197,94,.35)}
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="header-title"><i class="fas fa-user-shield me-2"></i>PANEL DE ADMINISTRADOR</h1>
                    <p class="header-subtitle">Sistema de Gestión Académica Universitaria</p>
                </div>
                <nav class="d-none d-lg-block">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.carrera.dashboard') ? 'active' : '' }}" href="{{ route('admin.carrera.dashboard') }}"><i class="fas fa-home me-2"></i>Inicio</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.carrera.estudiantes') ? 'active' : '' }}" href="{{ route('admin.carrera.estudiantes') }}"><i class="fas fa-users me-2"></i>Estudiantes</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fas fa-user-tie me-2"></i>Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.grupos.asignaciones') ? 'active' : '' }}" href="{{ route('admin.grupos.asignaciones') }}"><i class="fas fa-layer-group me-2"></i>Grupos</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reportes') ? 'active' : '' }}" href="{{ route('admin.reportes') }}"><i class="fas fa-chart-bar me-2"></i>Reportes</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.calendario') ? 'active' : '' }}" href="{{ route('admin.calendario') }}"><i class="fas fa-calendar me-2"></i>Calendario</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.notificaciones') ? 'active' : '' }}" href="{{ route('admin.notificaciones') }}"><i class="fas fa-bell me-2"></i>Notificaciones</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.chatbot') ? 'active' : '' }}" href="{{ route('admin.chatbot') }}"><i class="fas fa-robot me-2"></i>ChatBot</a></li>
                    </ul>
                </nav>
                <div class="dropdown d-none d-lg-block">
                    <button class="btn account-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ strtoupper(optional(auth()->user())->nombre ?? 'Usuario') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.perfil') }}"><i class="fas fa-id-badge me-2"></i>Mi perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="container my-4">
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
