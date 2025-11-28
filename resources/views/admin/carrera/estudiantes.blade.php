@extends('admin.layout')

@section('title', 'Estudiantes de la Carrera')
@section('content')
<h3>Vista General de Estudiantes</h3>

<form id="filtrosForm" method="GET" action="{{ route('admin.carrera.estudiantes') }}" class="row g-2 mb-3">
    <div class="col-md-3">
        <label class="form-label">Carrera</label>
        <select name="carrera_id" class="form-select">
            <option value="">Todas</option>
            @foreach($carreras as $c)
                <option value="{{ (string)$c->_id }}" {{ (string)$carreraId === (string)$c->_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Grupo</label>
        <select name="grupo_id" class="form-select">
            <option value="">Todos</option>
            @foreach($grupos as $g)
                <option value="{{ (string)$g->_id }}" {{ (string)$grupoId === (string)$g->_id ? 'selected' : '' }}>{{ $g->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Tutor</label>
        <select name="tutor_id" class="form-select">
            <option value="">Todos</option>
            @foreach($tutores as $t)
                <option value="{{ (string)$t->_id }}" {{ (string)$tutorId === (string)$t->_id ? 'selected' : '' }}>{{ $t->nombre }} {{ $t->app }} {{ $t->apm }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Búsqueda rápida</label>
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Nombre, apellidos o matrícula">
    </div>
    <div class="col-md-6 d-flex align-items-end justify-content-end">
        <button class="btn btn-success" type="submit">Aplicar filtros</button>
    </div>
</form>

@if(!$hasFilters)
    <div class="alert alert-info">Empieza a filtrar por grupo o escribe el nombre del alumno para ver resultados.</div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Matrícula</th>
                    <th>Carrera</th>
                    <th>Grupo</th>
                    <th>Tutor</th>
                    <th>Estado</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse($listado as $item)
                    <tr>
                        <td>{{ $item['alumno']->nombre }} {{ $item['alumno']->apellido_paterno }} {{ $item['alumno']->apellido_materno }}</td>
                        <td>{{ $item['alumno']->matricula }}</td>
                        <td>{{ optional($item['alumno']->carrera)->nombre ?? 'N/D' }}</td>
                        <td>{{ optional($item['alumno']->grupo)->nombre ?? 'N/D' }}</td>
                        <td>
                            @if(optional(optional($item['alumno']->grupo)->tutor)->nombre)
                                {{ $item['alumno']->grupo->tutor->nombre }} {{ $item['alumno']->grupo->tutor->app }} {{ $item['alumno']->grupo->tutor->apm }}
                            @elseif(optional($item['alumno']->user)->nombre)
                                {{ $item['alumno']->user->nombre }} {{ $item['alumno']->user->app }} {{ $item['alumno']->user->apm }}
                            @else
                                N/D
                            @endif
                        </td>
                        <td>
                            @if($item['riesgo'] === 'critico')
                                <span class="badge bg-danger">Crítico</span>
                            @elseif($item['riesgo'] === 'seguimiento')
                                <span class="badge bg-warning text-dark">Seguimiento</span>
                            @else
                                <span class="badge bg-success">Normal</span>
                            @endif
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="6">Sin resultados con los filtros seleccionados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

{{-- Búsqueda manual: el formulario se envía solo al pulsar el botón --}}
@endsection