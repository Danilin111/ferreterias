<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Producto;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::all();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        return view('facturas.create');
    }

    public function store(Request $request)
    {
        // Crear la factura
        $factura = Factura::create($request->only('fecha'));

        // Agregar productos existentes a la factura
        if ($request->has('producto_id')) {
            foreach ($request->producto_id as $key => $producto_id) {
                $cantidad = $request->cantidad_existente[$key];
                $producto = Producto::find($producto_id);

                // Actualizar stock
                $producto->cantidad_en_stock += $cantidad;
                $producto->save();

                // Asociar producto a la factura
                $factura->productos()->attach($producto_id, ['cantidad' => $cantidad]);
            }
        }

        // Crear un nuevo producto si se ha añadido
        if ($request->filled('nuevo_producto_nombre')) {
            $nuevoProducto = Producto::create([
                'nombre' => $request->nuevo_producto_nombre,
                'valor_neto' => $request->nuevo_producto_valor,
                'cantidad_en_stock' => $request->nuevo_producto_cantidad
            ]);

            // Asociar el nuevo producto a la factura
            $factura->productos()->attach($nuevoProducto->id, ['cantidad' => $request->nuevo_producto_cantidad]);
        }

        return redirect()->route('facturas.index')->with('success', 'Factura y productos añadidos correctamente');
    }


    public function show(Factura $factura)
    {
        return view('facturas.show', compact('factura'));
    }

    public function edit(Factura $factura)
    {
        return view('facturas.edit', compact('factura'));
    }

    public function update(Request $request, Factura $factura)
    {
        $factura->update($request->only('proveedor', 'fecha'));

        // Actualizar los productos
        $factura->productos()->detach();

        foreach ($request->producto_id as $key => $producto_id) {
            $nombreProducto = $request->producto_nombre[$key];
            $cantidad = $request->cantidad[$key];
            $valor = $request->valor[$key];

            // Verificar si el producto ya existe
            $producto = Producto::where('nombre', $nombreProducto)->first();

            if (!$producto) {
                // Si el producto no existe, lo creamos
                $producto = Producto::create([
                    'nombre' => $nombreProducto,
                    'valor_neto' => $valor,
                    'cantidad_en_stock' => $cantidad,
                ]);
            } else {
                // Si el producto ya existe, actualizamos la cantidad en stock
                $producto->cantidad_en_stock += $cantidad;
                $producto->save();
            }

            // Asociar el producto con la factura
            $factura->productos()->attach($producto->id, ['cantidad' => $cantidad]);
        }

        return redirect()->route('facturas.index');
    }

    public function destroy(Factura $factura)
    {
        $factura->delete();
        return redirect()->route('facturas.index');
    }
}
