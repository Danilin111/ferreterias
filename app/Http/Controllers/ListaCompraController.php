<?php

namespace App\Http\Controllers;

use App\Models\ListaCompra;
use Illuminate\Http\Request;

class ListaCompraController extends Controller
{
    public function index()
    {
        $listaCompras = ListaCompra::all();
        $totalGeneral = $listaCompras->sum('total');
        
        return view('lista_compras.index', compact('listaCompras', 'totalGeneral'));
    }
    
    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $listaCompras = ListaCompra::where('producto', 'LIKE', "%{$query}%")->get();
        $totalGeneral = $listaCompras->sum('total');
        
        return view('lista_compras.index', compact('listaCompras', 'totalGeneral'));
    }
    
    public function create()
    {
        return view('lista_compras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'fecha_estimada_pago' => 'required|date',
        ]);

        $total = $request->cantidad * $request->precio;

        ListaCompra::create([
            'producto' => $request->producto,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
            'total' => $total,
            'fecha_estimada_pago' => $request->fecha_estimada_pago,
        ]);

        return redirect()->route('lista_compras.index')
                         ->with('success', 'Producto añadido a la lista de compras.');
    }

    public function show(ListaCompra $listaCompra)
    {
        return view('lista_compras.show', compact('listaCompra'));
    }

    public function edit(ListaCompra $listaCompra)
    {
        return view('lista_compras.edit', compact('listaCompra'));
    }

    public function update(Request $request, ListaCompra $listaCompra)
    {
        $request->validate([
            'producto' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'fecha_estimada_pago' => 'required|date',
        ]);

        $total = $request->cantidad * $request->precio;

        $listaCompra->update([
            'producto' => $request->producto,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
            'total' => $total,
            'fecha_estimada_pago' => $request->fecha_estimada_pago,
        ]);

        return redirect()->route('lista_compras.index')
                         ->with('success', 'Producto actualizado en la lista de compras.');
    }

    public function destroy(ListaCompra $listaCompra)
    {
        $listaCompra->delete();

        return redirect()->route('lista_compras.index')
                         ->with('success', 'Producto eliminado de la lista de compras.');
    }
}
