@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>
    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del Producto</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="form-group">
            <label for="valor_neto">Valor Neto</label>
            <input type="number" name="valor_neto" class="form-control" value="{{ old('valor_neto', $producto->valor_neto) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="cantidad_en_stock">Cantidad en Stock</label>
            <input type="number" name="cantidad_en_stock" class="form-control" value="{{ old('cantidad_en_stock', $producto->cantidad_en_stock) }}" required>
        </div>

        <div class="form-group">
            <label for="porcentaje_ganancia">Porcentaje de Ganancia</label>
            <input type="number" name="porcentaje_ganancia" class="form-control" value="{{ old('porcentaje_ganancia', $producto->porcentaje_ganancia ?? 40) }}" step="0.01" max="100" min="0">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
    </form>
</div>
@endsection
