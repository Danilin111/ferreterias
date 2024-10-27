<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        
        $fechaSeleccionada = $request->input('fecha', Carbon::today()->toDateString());
        $ventas = Venta::whereDate('created_at', $fechaSeleccionada)->paginate(50);
        $gananciasTotales = $ventas->sum('total');

        return view('ventas.index', compact('ventas', 'fechaSeleccionada', 'gananciasTotales'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('ventas.create', compact('productos'));
    }

    public function getProductos(Request $request)
    {
        $search = $request->get('search');
        $productos = Producto::where('nombre', 'like', '%' . $search . '%')->get();

        return response()->json($productos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);

        if ($producto->cantidad_en_stock < $request->cantidad) {
            return redirect()->back()->withErrors(['Cantidad insuficiente en stock']);
        }

        $totalVenta = $producto->precio_venta * $request->cantidad;

        // Crear la venta
        $venta = Venta::create([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $totalVenta,
        ]);

        // Actualizar stock del producto
        $producto->cantidad_en_stock -= $request->cantidad;
        $producto->save();

        // Actualizar presupuesto
        $presupuesto = Presupuesto::first();
        if (!$presupuesto) {
            $presupuesto = Presupuesto::create(['monto' => 0]);
        }
        $presupuesto->monto += $totalVenta;
        $presupuesto->save();

        return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente');
    }

    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $productos = Producto::all();
        return view('ventas.edit', compact('venta', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);

        // Revertir la cantidad anterior de producto
        $producto->cantidad_en_stock += $venta->cantidad;
        $producto->save();

        // Revertir el total anterior del presupuesto
        $presupuesto = Presupuesto::first();
        $presupuesto->monto -= $venta->total;
        $presupuesto->save();

        // Actualizar venta con nueva información
        $totalVenta = $producto->precio_venta * $request->cantidad;
        $venta->update([
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'total' => $totalVenta,
        ]);

        // Actualizar cantidad de producto en stock con nueva cantidad
        $producto->cantidad_en_stock -= $request->cantidad;
        $producto->save();

        // Actualizar presupuesto con el nuevo total
        $presupuesto->monto += $totalVenta;
        $presupuesto->save();

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente');
    }

    public function destroy(Venta $venta)
    {
        // Revertir la cantidad de producto en stock
        $producto = Producto::find($venta->producto_id);
        $producto->cantidad_en_stock += $venta->cantidad;
        $producto->save();

        // Revertir el total del presupuesto
        $presupuesto = Presupuesto::first();
        $presupuesto->monto -= $venta->total;
        $presupuesto->save();

        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente');
    }

    // Función de venta rápida
    public function ventaRapida(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);

        // Verificar si el producto existe y si hay suficiente stock
        if ($producto && $producto->cantidad_en_stock >= $request->cantidad) {
            $cantidad = $request->cantidad;
            $totalVenta = $producto->precio_venta * $cantidad;

            // Crear la venta
            $venta = Venta::create([
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'total' => $totalVenta,
            ]);

            // Actualizar la cantidad en stock del producto
            $producto->cantidad_en_stock -= $cantidad;
            $producto->save();

            // Actualizar el presupuesto
            $presupuesto = Presupuesto::first();
            if (!$presupuesto) {
                $presupuesto = Presupuesto::create(['monto' => 0]);
            }
            $presupuesto->monto += $totalVenta;
            $presupuesto->save();

            return redirect()->route('productos.index')->with('success', 'Venta rápida registrada exitosamente.');
        }

        return redirect()->route('productos.index')->with('error', 'Producto sin stock suficiente.');
    }
}
