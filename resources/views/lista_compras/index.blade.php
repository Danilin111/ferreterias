@extends('layouts.app')

@section('content')
<form action="{{ route('lista_compras.buscar') }}" method="GET" class="d-flex mb-4">
    <input type="text" name="query" class="form-control me-2" placeholder="Buscar en lista de compras..." aria-label="Buscar">
    <button class="btn btn-outline-success" type="submit">Buscar</button>
</form>

@if(isset($listaCompras) && $listaCompras->isNotEmpty())
@elseif(isset($listaCompras))
    <div class="alert alert-warning" role="alert">
        No se encontraron productos.
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista de Compras</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('lista_compras.create') }}"> Añadir Producto</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th>Fecha Estimada de Pago</th>
            <th width="280px">Acciones</th>
        </tr>
        @foreach ($listaCompras as $listaCompra)
        <tr>
            
            <td>{{ $listaCompra->producto }}</td>
            <td>{{ $listaCompra->cantidad }}</td>
            <td>{{ $listaCompra->precio }}</td>
            <td>{{ $listaCompra->total }}</td>
            <td>{{ $listaCompra->fecha_estimada_pago }}</td>
            <td>
                <form action="{{ route('lista_compras.destroy', $listaCompra->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('lista_compras.show', $listaCompra->id) }}">Mostrar</a>

                    <a class="btn btn-primary" href="{{ route('lista_compras.edit', $listaCompra->id) }}">Editar</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td><strong>Total General:</strong> {{ $totalGeneral }}</td>
            <td colspan="2"></td>
        </tr>
    </table>
</div>
@endsection
