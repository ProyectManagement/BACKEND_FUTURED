@extends('admin.layout')

@section('title', 'Usuarios')

@section('content')
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
@endsection