<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('nombre', 'asc')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'valor_neto' => 'required|numeric|min:0',
        'cantidad_en_stock' => 'required|integer|min:0',
        'porcentaje_ganancia' => 'nullable|numeric|min:0|max:100',
    ]);

    // Crear el producto
    $producto = Producto::create([
        'nombre' => $request->nombre,
        'valor_neto' => $request->valor_neto,
        'porcentaje_ganancia' => $request->porcentaje_ganancia ?? 40, // Si no se especifica, usa el 40%
        'cantidad_en_stock' => $request->cantidad_en_stock,
    ]);

    // Calcular el precio de venta usando el porcentaje de ganancia
    $producto->precio_venta = $producto->valor_neto * (1 + ($producto->porcentaje_ganancia / 100));
    $producto->save();

    return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
}


    public function show(Producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'valor_neto' => 'required|numeric|min:0',
        'cantidad_en_stock' => 'required|integer|min:0',
        'porcentaje_ganancia' => 'nullable|numeric|min:0|max:100',
    ]);

    // Actualizar el producto
    $producto->update([
        'nombre' => $request->nombre,
        'valor_neto' => $request->valor_neto,
        'porcentaje_ganancia' => $request->porcentaje_ganancia ?? 40, // Si no se especifica, usa el 40%
        'cantidad_en_stock' => $request->cantidad_en_stock,
    ]);

    // Recalcular el precio de venta
    $producto->precio_venta = $producto->valor_neto * (1 + ($producto->porcentaje_ganancia / 100));
    $producto->save();

    return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
}

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');
        $productos = Producto::where('nombre', 'LIKE', "%{$query}%")->paginate(100);
        return view('productos.index', compact('productos'));
        return view('productos.index', with(['productos'=>$productos]));
    }
}




