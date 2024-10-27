@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Venta</h1>
    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="producto_id">Producto</label>
            <select class="form-control" name="producto_id" required>
                @foreach($productos as $producto)
                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input type="number" class="form-control" name="cantidad" required>
        </div>
        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" step="0.01" class="form-control" name="total" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const productoSelect = document.querySelector('select[name="producto_id"]');
    const cantidadInput = document.querySelector('input[name="cantidad"]');
    const totalInput = document.querySelector('input[name="total"]');

    function actualizarTotal() {
        const precio = productoSelect.options[productoSelect.selectedIndex].getAttribute('data-precio');
        const cantidad = cantidadInput.value;
        totalInput.value = (precio * cantidad).toFixed(2);
    }

    productoSelect.addEventListener('change', actualizarTotal);
    cantidadInput.addEventListener('input', actualizarTotal);
});
</script>
@endsection
