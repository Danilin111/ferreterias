@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Gasto</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $gasto->descripcion }}</h5>
            <p class="card-text">Monto: {{ $gasto->monto }}</p>
            <p class="card-text">Fecha: {{ $gasto->created_at }}</p>
            <a href="{{ route('gastos.edit', $gasto->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('gastos.destroy', $gasto->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
@endsection
