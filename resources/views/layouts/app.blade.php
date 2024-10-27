<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta para hacer la página responsive -->
    <title>Ferretería</title>
    
    <!-- Bootstrap CSS para diseño responsivo -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- JQuery y JQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        .presupuesto-container {
            position: relative;
            display: inline-block;
        }
        
        /* Botón de reinicio presupuesto */
        .btn-reiniciar-presupuesto {
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            margin-top: -2px;
        }
        
        .presupuesto-container:hover .btn-reiniciar-presupuesto {
            display: inline-block;
        }

        /* Botones de scroll */
        #scrollTopButton, #scrollBottomButton {
            position: fixed;
            right: 20px;
            padding: 10px;
            font-size: 14px;
            border-radius: 50px;
            color: #fff;
        }
        
        #scrollTopButton {
            bottom: 80px;
            background-color: #3498db;
        }

        #scrollBottomButton {
            bottom: 20px;
            background-color: #2ecc71;
        }

        /* Asegurar contenedor ajustable en móvil */
        .container {
            max-width: 100%;
            padding: 15px;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación con diseño responsive -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Ferretería</a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="/productos">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="/ventas">Ventas</a></li>
                <li class="nav-item"><a class="nav-link" href="/gastos">Gastos</a></li>
                <li class="nav-item"><a class="nav-link" href="/lista_compras">Lista Compras</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reportes.index') }}">Reportes</a></li>
            </ul>
            <div class="presupuesto-container">
                <span class="navbar-text">
                    Presupuesto Actual: ${{ \App\Http\Controllers\PresupuestoController::getPresupuesto() }}
                </span>
                <a href="{{ route('presupuesto.reiniciar') }}" class="btn btn-danger btn-reiniciar-presupuesto">Reiniciar</a>
            </div>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </div>
    
    <!-- Botones de desplazamiento -->
    <div id="scrollTopButton" class="scroll-button">
        <i class="fas fa-arrow-up" onclick="scrollToTop()"></i>
    </div>
    <div id="scrollBottomButton" class="scroll-button">
        <i class="fas fa-arrow-down" onclick="scrollToBottom()"></i>
    </div>

    <!-- Scripts de desplazamiento -->
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function scrollToBottom() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }
    </script>
    
    <!-- Bootstrap JS para el menú responsive -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
