@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Pedidos</h1>

    <a href="{{ route('pedidos.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Pedido</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->producto->nombre }}</td>
                    <td>{{ $pedido->cantidad }}</td>
                    <td>{{ $pedido->fecha }}</td>
                    <td>
                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
