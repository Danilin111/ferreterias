<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index()
    {
        $gastos = Gasto::all();
        return view('gastos.index', compact('gastos'));
    }

    public function create()
    {
        return view('gastos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'monto' => 'required|numeric',
        ]);

        $gasto = new Gasto([
            'descripcion' => $request->get('descripcion'),
            'monto' => $request->get('monto'),
        ]);
        $gasto->save();

        // Actualizar presupuesto
        $presupuesto = Presupuesto::first();
        if ($presupuesto) {
            $presupuesto->monto -= $gasto->monto;
            $presupuesto->save();
        }

        return redirect()->route('gastos.index')->with('success', 'Gasto registrado');
    }

    public function show(Gasto $gasto)
    {
        return view('gastos.show', compact('gasto'));
    }

    public function edit(Gasto $gasto)
    {
        return view('gastos.edit', compact('gasto'));
    }

    public function update(Request $request, Gasto $gasto)
    {
        $request->validate([
            'descripcion' => 'required',
            'monto' => 'required|numeric',
        ]);

        // Actualizar presupuesto (revertir cambio anterior y aplicar nuevo)
        $presupuesto = Presupuesto::first();
        if ($presupuesto) {
            $presupuesto->monto += $gasto->monto; // Revertir el gasto anterior
            $presupuesto->monto -= $request->get('monto'); // Aplicar el gasto actualizado
            $presupuesto->save();
        }

        $gasto->update([
            'descripcion' => $request->get('descripcion'),
            'monto' => $request->get('monto'),
        ]);

        return redirect()->route('gastos.index')->with('success', 'Gasto actualizado');
    }

    public function destroy(Gasto $gasto)
    {
        // Actualizar presupuesto al eliminar un gasto
        $presupuesto = Presupuesto::first();
        if ($presupuesto) {
            $presupuesto->monto += $gasto->monto;
            $presupuesto->save();
        }

        $gasto->delete();
        return redirect()->route('gastos.index')->with('success', 'Gasto eliminado');
    }
}
