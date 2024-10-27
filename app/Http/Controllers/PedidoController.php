<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('producto')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('pedidos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'producto_existente' => 'nullable|exists:productos,id',
            'nombre_nuevo_producto' => 'nullable|string|max:255',
            'valor_neto' => 'nullable|numeric',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'required|date',
        ]);

        // Si seleccionó un producto existente
        if ($request->filled('producto_existente')) {
            $producto = Producto::find($request->producto_existente);
        } 
        // Si ingresó un nuevo producto
        else if ($request->filled('nombre_nuevo_producto') && $request->filled('valor_neto')) {
            $producto = Producto::create([
                'nombre' => $request->nombre_nuevo_producto,
                'valor_neto' => $request->valor_neto,
                'cantidad_en_stock' => 0, // Inicialmente en 0, luego se actualiza
            ]);
        } else {
            return redirect()->back()->withErrors('Debes seleccionar un producto existente o ingresar un nuevo producto.');
        }

        // Actualizar la cantidad en stock del producto
        $producto->cantidad_en_stock += $request->cantidad;
        $producto->save();

        // Crear el pedido
        Pedido::create([
            'producto_id' => $producto->id,
            'cantidad' => $request->cantidad,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido registrado y producto actualizado.');
        
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $productos = Producto::all();
        return view('pedidos.edit', compact('pedido', 'productos'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'required|date',
        ]);

        // Revertir la cantidad del pedido anterior
        $producto = Producto::find($pedido->producto_id);
        $producto->cantidad_en_stock -= $pedido->cantidad;
        
        // Actualizar el pedido
        $pedido->update($request->all());

        // Actualizar la cantidad de productos
        $producto->cantidad_en_stock += $request->cantidad;
        $producto->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado.');
    }

    public function destroy(Pedido $pedido)
    {
        // Revertir la cantidad en stock del producto
        $producto = Producto::find($pedido->producto_id);
        $producto->cantidad_en_stock -= $pedido->cantidad;
        $producto->save();

        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado y producto actualizado.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $productos = Producto::where('nombre', 'LIKE', "%{$query}%")->get();
        return response()->json($productos);
    }

    
}
