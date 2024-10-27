@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Venta</h1>

    <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select name="producto_id" id="producto_id" class="form-control">
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}" {{ $venta->producto_id == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ $venta->cantidad }}" required>
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" name="total" id="total" class="form-control" value="{{ $venta->total }}" required>
        </div>

        <div class="form-group">
            <label for="created_at">Fecha</label>
            <input type="date" name="created_at" id="created_at" class="form-control" value="{{ $venta->created_at->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
