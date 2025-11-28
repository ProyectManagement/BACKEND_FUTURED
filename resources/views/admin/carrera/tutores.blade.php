@extends('admin.layout')

@section('title', 'Monitoreo de Tutores')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3>Monitoreo de Tutores</h3>
    <form method="GET" action="{{ route('admin.carrera.tutores') }}" class="d-flex gap-2">
        <select name="carrera_id" class="form-select form-select-sm" style="min-width: 240px;">
            <option value="">Todas las carreras</option>
            @foreach($carreras as $c)
                <option value="{{ (string)$c->_id }}" {{ (string)$carreraId === (string)$c->_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
        <button class="btn btn-success btn-sm" type="submit">Aplicar</button>
    </form>
</div>

<div class="card mb-3"><div class="card-body">
    <h5>Carga de trabajo promedio</h5>
    <p class="mb-0">Estudiantes por tutor: <strong>{{ $promedio }}</strong></p>
</div></div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Tutor</th>
                <th>Estudiantes</th>
                <th>Asesorías realizadas</th>
                <th>Casos pendientes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($porTutor as $item)
                <tr>
                    <td>{{ $item['tutor']->nombre }} {{ $item['tutor']->app }} {{ $item['tutor']->apm }}</td>
                    <td>{{ $item['estudiantes'] }}</td>
                    <td>{{ $item['asesorias'] }}</td>
                    <td>
                        @if($item['pendientes'])
                            <span class="badge bg-danger">Crítico</span>
                        @else
                            <span class="badge bg-success">Sin pendientes</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.grupos.asignaciones') }}">Reasignar estudiantes</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay tutores registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection