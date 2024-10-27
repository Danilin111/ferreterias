
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
    <h1>Lista de Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-light">Registrar Producto</a>
    <div class="table-responsive">
    
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" >Nombre</th>
                <th scope="col">Valor neto</th>
                <th scope="col">Cantidad en Stock</th>
                <th scope="col">Precio de Venta</th>
             
                <th>Acciones</th>
                <th scope="col">Venta Rapida</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->valor_neto }}</td>
                <td>{{ $producto->cantidad_en_stock }}</td>
                <td>{{ $producto->precio_venta }}</td>
                <td class="btn-group-vertical">
                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info mb-2">Ver</a>
                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning mb-2">Editar</a>
                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('ventas.rapida') }}" method="POST">
                        @csrf
                        <input class="" type="hidden" name="producto_id" value="{{ $producto->id }}">            
                        <div class="form-group">
                            <input type="number" name="cantidad" min="1" max="{{ $producto->cantidad_en_stock }}" value="1" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart"></i> VENDER
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
