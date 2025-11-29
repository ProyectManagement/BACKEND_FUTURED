<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Notificaciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
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
