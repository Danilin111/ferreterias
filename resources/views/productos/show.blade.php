@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Producto: {{ $producto->nombre }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Producto: {{ $producto->nombre }}</h5>
            <p class="card-text">Valor Neto: ${{ number_format($producto->valor_neto, 0, ',', '.') }}</p>
            <p class="card-text">Precio de Venta: ${{ number_format($producto->precio_venta, 0, ',', '.') }}</p>
            <p class="card-text">Ganancia: ${{ number_format($producto->ganancia(), 0, ',', '.') }}</p>
        </div>
    </div>

    <a href="{{ route('productos.index') }}" class="btn btn-primary mt-3">Volver a la lista de productos</a>
</div>
@endsection
