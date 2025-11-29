@extends('admin.layout')

@section('title', 'Mi Perfil')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-user me-2"></i> Mi Perfil</h5>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.perfil.update') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido paterno</label>
                        <input type="text" name="app" class="form-control" value="{{ old('app', $user->app) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido materno</label>
                        <input type="text" name="apm" class="form-control" value="{{ old('apm', $user->apm) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo', $user->correo) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contraseña" class="form-control" placeholder="Dejar vacío para mantener">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Guardar cambios</button>
                    <a href="{{ route('admin.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Volver</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
