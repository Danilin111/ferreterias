@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Registrar Pedido</h1>

    <form action="{{ route('pedidos.store') }}" method="POST">
        @csrf

        <!-- Búsqueda de productos existentes -->
        <div class="form-group">
            <label for="producto_existente">Buscar producto existente</label>
            <input type="text" id="producto_existente" class="form-control" placeholder="Escribe el nombre del producto">
            <ul id="lista_productos" class="list-group mt-2" style="display:none;"></ul>
            <input type="hidden" name="producto_id" id="producto_id">
        </div>

        <h4>O agregar nuevo producto</h4>

        <div class="form-group">
            <label for="nombre_nuevo_producto">Nombre del nuevo producto</label>
            <input type="text" name="nombre_nuevo_producto" id="nombre_nuevo_producto" class="form-control" placeholder="Nuevo producto">
        </div>

        <div class="form-group">
            <label for="valor_neto">Valor neto del nuevo producto</label>
            <input type="number" name="valor_neto" id="valor_neto" class="form-control" placeholder="Valor neto">
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad del pedido</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha del Pedido</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Pedido</button>
    </form>
</div>

<!-- Agregar jQuery para el autocomplete -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Buscar productos en tiempo real
    $('#producto_existente').on('keyup', function() {
        var query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{route('buscarProductoExistente')}}", // Ruta para la búsqueda
                type: "post",
                data: {
                    'query': query,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#lista_productos').empty().show();
                    if (data.length > 0) {
                        $.each(data, function(key, producto) {
                            $('#lista_productos').append('<li class="list-group-item" data-id="'+ producto.id +'">'+ producto.nombre +'</li>');
                        });
                    } else {
                        $('#lista_productos').append('<li class="list-group-item">No se encontraron productos</li>');
                    }
                }
            });
        } else {
            $('#lista_productos').hide();
        }
    });

    // Seleccionar producto de la lista
    $(document).on('click', '#lista_productos li', function() {
        var producto_id = $(this).data('id');
        var producto_nombre = $(this).text();

        $('#producto_existente').val(producto_nombre);
        $('#producto_id').val(producto_id);
        $('#lista_productos').hide();
    });
});
</script>
@endsection
