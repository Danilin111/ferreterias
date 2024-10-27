@extends('layouts.app')

@section('content')

<form action="{{ route('productos.buscar') }}" method="GET" class="d-flex mb-4">
    <input type="text" name="query" class="form-control me-2" placeholder="Buscar productos..." aria-label="Buscar">
    <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>

    @if(isset($productos) && $productos->isNotEmpty())
    @elseif(isset($productos))
    <div class="alert alert-warning" role="alert">
        No se encontraron productos.
    </div>
    @endif
<div class="container">
    <h1>Ventas</h1>

    <form action="{{ route('ventas.index') }}" method="GET" class="mb-3">
        <div class="form-group row">
            <label for="fecha" class="col-sm-2 col-form-label">Fecha:</label>
            <div class="col-sm-4">
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $fechaSeleccionada }}">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    @if($ventas->isEmpty())
        <div class="alert alert-warning">No hay ventas registradas para esta fecha.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>{{ $venta->cantidad }}</td>
                        <td>{{ $venta->total }}</td>
                        <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar esta venta?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Mostrando el total de ganancias diarias -->
        <div class="alert alert-success">
            <strong>Ganancias Totales del Día: </strong> ${{ number_format($gananciasTotales, 2) }}
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $ventas->links() }}
        </div>
    @endif
</div>
@endsection
