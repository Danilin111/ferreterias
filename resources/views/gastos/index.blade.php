@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Gastos</h1>
    <a href="{{ route('gastos.create') }}" class="btn btn-primary mb-3">Registrar Gasto</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gastos as $gasto)
            <tr>
                <td>{{ $gasto->descripcion }}</td>
                <td>{{ $gasto->monto }}</td>
                <td>{{ $gasto->created_at }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('gastos.edit', $gasto->id) }}">Editar</a>
                    <form action="{{ route('gastos.destroy', $gasto->id) }}" method="POST" style="display:inline-block;">
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
