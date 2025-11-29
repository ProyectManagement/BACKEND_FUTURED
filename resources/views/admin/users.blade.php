<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Usuarios</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
    <script>(function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
    <style>
        :root { --green:#22c55e; --green-dark:#16a34a; --text:#0b1321; --muted:#475569; --border:#e2e8f0; --bg:#f8fafc; --panel-bg:#fff; --chip-bg:#f1f5f9; }
        :root[data-theme="dark"] { --bg:#0b1220; --text:#e5e7eb; --muted:#9aa4b2; --border:#1f2937; --panel-bg:#0b1220; --chip-bg:#0f172a; }
        *{box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;background:var(--bg);min-height:100vh;color:var(--text)}
        .main-header{background:var(--panel-bg);border-bottom:1px solid var(--border);padding:1rem 0;position:sticky;top:0;z-index:1000;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .header-title{font-weight:800;font-size:1.8rem;margin:0;color:var(--text)}
        .header-subtitle{color:var(--muted);font-size:.95rem;margin:0}
        .nav-pills .nav-link{color:var(--text);background:var(--chip-bg);border-radius:999px;padding:.7rem 1.2rem;margin:0 .25rem;font-weight:600;border:1px solid var(--border)}
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
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userModal" onclick="openCreateModal()">Crear Usuario</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="usersTable">
            @foreach ($users as $user)
                <tr id="user-{{ $user->_id }}">
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->app }}</td>
                    <td>{{ $user->apm }}</td>
                    <td>{{ $user->correo }}</td>
                    <td>{{ $user->role ? $user->role->nombre : 'Sin rol' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="openEditModal('{{ $user->_id }}')">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser('{{ $user->_id }}')">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        @csrf
                        <input type="hidden" id="userId" name="userId">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="app" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="app" name="app" required>
                        </div>
                        <div class="mb-3">
                            <label for="apm" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="apm" name="apm" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <select class="form-control" id="id_rol" name="id_rol" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->_id }}">{{ $role->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="errorMessages" class="text-danger"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configurar CSRF para todas las solicitudes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Verificar si el token CSRF está presente
        console.log('Token CSRF:', $('meta[name="csrf-token"]').attr('content'));

        function openCreateModal() {
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#password').prop('required', true);
            $('#userModalLabel').text('Crear Usuario');
            $('#errorMessages').empty();
            $('#userModal').modal('show');
        }

        function openEditModal(id) {
            $.ajax({
                url: '/admin/users/' + id + '/edit',
                method: 'GET',
                success: function(data) {
                    console.log('Datos del usuario recibidos:', JSON.stringify(data, null, 2));
                    if (!data.user) {
                        console.error('Error: No se encontró el objeto user en la respuesta');
                        $('#errorMessages').html('<p>Error: Respuesta del servidor no contiene datos del usuario.</p>');
                        return;
                    }
                    // Usar data.user.id o data.user._id
                    const userId = data.user.id || data.user._id;
                    if (!userId) {
                        console.error('Error: Ni id ni _id encontrados en data.user');
                        $('#errorMessages').html('<p>Error: No se encontró el ID del usuario.</p>');
                        return;
                    }
                    $('#userId').val(userId);
                    $('#nombre').val(data.user.nombre || '');
                    $('#app').val(data.user.app || '');
                    $('#apm').val(data.user.apm || '');
                    $('#correo').val(data.user.correo || '');
                    $('#id_rol').val(data.user.id_rol || '');
                    $('#password').val('').prop('required', false);
                    $('#userModalLabel').text('Editar Usuario');
                    $('#errorMessages').empty();
                    $('#userModal').modal('show');
                    console.log('userId establecido:', $('#userId').val());
                },
                error: function(xhr) {
                    console.error('Error al cargar datos del usuario:', xhr.status, xhr.responseText);
                    $('#errorMessages').html('<p>Error al cargar los datos del usuario: ' + (xhr.responseJSON?.message || xhr.statusText) + '</p>');
                }
            });
        }

        function saveUser() {
            const userId = $('#userId').val();
            const url = userId ? '/admin/users/' + userId : '/admin/users';
            const method = userId ? 'PUT' : 'POST';
            const formData = $('#userForm').serialize();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            console.log('URL:', url);
            console.log('Método:', method);
            console.log('Token CSRF:', csrfToken);
            console.log('Datos del formulario:', formData);
            console.log('User ID:', userId);

            if (!userId && $('#userModalLabel').text() === 'Editar Usuario') {
                console.error('Error: userId está vacío en modo edición');
                $('#errorMessages').html('<p>Error: ID de usuario no especificado.</p>');
                return;
            }

            $.ajax({
                url: url,
                method: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log('Usuario guardado:', response);
                    $('#userModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error('Error al guardar usuario:', xhr.status, xhr.responseText);
                    const errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                    let errorHtml = '';
                    if (errors) {
                        for (let key in errors) {
                            errorHtml += `<p>${errors[key][0]}</p>`;
                        }
                    } else {
                        errorHtml = '<p>Error inesperado: ' + (xhr.responseJSON?.message || xhr.statusText) + '</p>';
                    }
                    $('#errorMessages').html(errorHtml);
                }
            });
        }

        function deleteUser(id) {
            if (confirm('¿Estás seguro de eliminar este usuario?')) {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                console.log('Eliminando usuario con ID:', id);
                console.log('Token CSRF para DELETE:', csrfToken);

                $.ajax({
                    url: '/admin/users/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        console.log('Usuario eliminado:', response);
                        $('#user-' + id).remove();
                    },
                    error: function(xhr) {
                        console.error('Error al eliminar usuario:', xhr.status, xhr.responseText);
                        $('#errorMessages').html('<p>Error al eliminar el usuario: ' + (xhr.responseJSON?.message || xhr.statusText) + '</p>');
                    }
                });
            }
        }
    </script>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
