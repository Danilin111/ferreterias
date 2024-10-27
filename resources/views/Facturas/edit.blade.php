@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Factura ID: {{ $factura->id }}</h1>

        <form action="{{ route('facturas.update', $factura->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ $factura->fecha }}">
            </div>

            <h3>Productos</h3>
            <div id="productos">
                @foreach ($factura->productos as $producto)
                    <div class="form-group">
                        <label for="producto_id">Producto</label>
                        <select name="producto_id[]" class="form-control">
                            @foreach($productos as $prod)
                                <option value="{{ $prod->id }}" {{ $prod->id == $producto->id ? 'selected' : '' }}>{{ $prod->nombre }}</option>
                            @endforeach
                        </select>

                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad[]" class="form-control" value="{{ $producto->pivot->cantidad }}">
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Factura</button>
        </form>
    </div>
@endsection
