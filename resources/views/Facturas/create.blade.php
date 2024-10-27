<form action="{{ route('facturas.store') }}" method="POST">
    @csrf
    <!-- Datos de la Factura -->
    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" required>

    <!-- Productos Existentes -->
    <h4>Productos Existentes</h4>
    <div id="productos-existentes">
        @foreach ($productos as $producto)
            <label>
                <input type="checkbox" name="producto_id[]" value="{{ $producto->id }}">
                {{ $producto->nombre }} - Stock: {{ $producto->cantidad_en_stock }}
            </label>
            <input type="number" name="cantidad_existente[]" placeholder="Cantidad" min="1">
        @endforeach
    </div>

    <!-- Agregar Nuevo Producto -->
    <h4>Agregar Nuevo Producto</h4>
    <div id="nuevo-producto">
        <input type="text" name="nuevo_producto_nombre" placeholder="Nombre del Producto">
        <input type="number" name="nuevo_producto_valor" placeholder="Valor Neto">
        <input type="number" name="nuevo_producto_cantidad" placeholder="Cantidad en Stock" min="1">
    </div>

    <button type="submit">Guardar Factura</button>
</form>
