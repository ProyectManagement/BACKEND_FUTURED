@extends('admin.layout')

@section('title','Asignar Tutor a Grupo')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Asignar Tutor a Grupo</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
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
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="asignarForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Grupo</label>
                            <select id="grupoSelect" class="form-select" required>
                                <option value="" disabled selected>Selecciona un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ (string)$grupo->_id }}">
                                        {{ $grupo->nombre }}
                                        @if($grupo->carrera) - {{ $grupo->carrera->nombre }} @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tutor</label>
                            <select name="tutor_id" class="form-select" required>
                                <option value="" disabled selected>Selecciona un tutor</option>
                                @forelse($tutores as $tutor)
                                    <option value="{{ (string)$tutor->_id }}">
                                        {{ strtoupper($tutor->nombre) }} {{ strtoupper($tutor->app) }} {{ strtoupper($tutor->apm) }}
                                    </option>
                                @empty
                                    <option value="" disabled>No hay tutores disponibles</option>
                                @endforelse
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Asignar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Asignaciones actuales</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Grupo</th>
                                    <th>Carrera</th>
                                    <th>Tutor asignado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grupos as $grupo)
                                    <tr>
                                        <td>{{ $grupo->nombre }}</td>
                                        <td>{{ $grupo->carrera->nombre ?? 'Sin carrera' }}</td>
                                        <td>
                                            @if($grupo->tutor)
                                                {{ strtoupper($grupo->tutor->nombre) }} {{ strtoupper($grupo->tutor->app) }} {{ strtoupper($grupo->tutor->apm) }}
                                            @else
                                                Sin tutor
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('asignarForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const grupoId = document.getElementById('grupoSelect').value;
    if (!grupoId) return;
    const form = e.target;
    form.action = `{{ url('/admin/grupos') }}/${grupoId}/asignar-tutor`;
    form.submit();
});
</script>
@endpush
@endsection
