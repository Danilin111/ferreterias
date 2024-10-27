@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Factura ID: {{ $factura->id }}</h1>

        <p>Fecha: {{ $factura->fecha }}</p>
        <p>Total: {{ $factura->total }}</p>

        <h3>Productos</h3>
        <ul>
            @foreach ($factura->productos as $producto)
                <li>{{ $producto->nombre }} - Cantidad: {{ $producto->pivot->cantidad }}</li>
            @endforeach
        </ul>

        <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Volver a la lista de facturas</a>
    </div>
@endsection
