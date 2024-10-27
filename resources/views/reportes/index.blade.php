@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reportes y Estadísticas</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Ventas Totales</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($ventasTotales, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Gastos Totales</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($gastosTotales, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Balance</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($balance, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>

    <h2>Ventas por Mes</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Total Ventas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventasPorMes as $venta)
                <tr>
                    <td>{{ $venta->year }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($venta->month)->format('F') }}</td>
                    <td>{{ number_format($venta->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Gastos por Mes</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Año</th>
                <th>Mes</th>
                <th>Total Gastos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gastosPorMes as $gasto)
                <tr>
                    <td>{{ $gasto->year }}</td>
                    <td>{{ \Carbon\Carbon::create()->month($gasto->month)->format('F') }}</td>
                    <td>{{ number_format($gasto->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
