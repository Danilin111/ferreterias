<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Gasto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // Calcular ventas totales
        $ventasTotales = Venta::sum('total');

        // Calcular gastos totales
        $gastosTotales = Gasto::sum('monto');

        // Calcular balance (ventas - gastos)
        $balance = $ventasTotales - $gastosTotales;

        // Ventas por mes
        $ventasPorMes = Venta::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Gastos por mes
        $gastosPorMes = Gasto::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(monto) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('reportes.index', compact('ventasTotales', 'gastosTotales', 'balance', 'ventasPorMes', 'gastosPorMes'));
    }
}
