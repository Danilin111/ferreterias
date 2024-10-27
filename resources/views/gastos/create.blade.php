@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Gasto</h1>
    <form action="{{ route('gastos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" class="form-control" name="descripcion" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto</label>
            <input type="number" step="0.01" class="form-control" name="monto" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
