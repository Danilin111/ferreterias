@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de la Venta</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Producto: {{ $venta->producto->nombre }}</h5>
            <p class="card-text">Cantidad: {{ $venta->cantidad }}</p>
            <p class="card-text">Total: {{ $venta->total }}</p>
            <p class="card-text">Fecha: {{ $venta->created_at }}</p>
            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
