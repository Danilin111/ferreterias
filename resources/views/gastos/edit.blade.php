@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Gasto</h1>
    <form action="{{ route('gastos.update', $gasto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ old('descripcion', $gasto->descripcion) }}" required>
        </div>

        <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="number" name="monto" id="monto" class="form-control" value="{{ old('monto', $gasto->monto) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $gasto->fecha) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('gastos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
