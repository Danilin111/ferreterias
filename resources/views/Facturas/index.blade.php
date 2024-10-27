@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Facturas</h1>

        <a href="{{ route('facturas.create') }}" class="btn btn-primary">Añadir Nueva Factura</a>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($facturas as $factura)
                <tr>
                    <td>{{ $factura->id }}</td>
                    <td>{{ $factura->fecha }}</td>
                    <td>{{ $factura->total }}</td>
                    <td>
                        <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
