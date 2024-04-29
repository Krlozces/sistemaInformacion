<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('js/importante.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>
<body>
    <header class="header">
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu" > <img src="{{ asset('images/logo.png') }}" class="imagen"> </label>
            </div>
            <div class="logo">
                <h1>Dosaje Etílico</h1>
            </div>
            <nav class="menu">
                <label for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}" class="imagen1"> </label>
                <h3 class="expandable">{{ Auth::user()->name }}</h3>
                <ul class="submenu">
                    <li><a href="#"><i class="fa-solid fa-users-viewfinder"></i> Cambiar foto</a></li>
                    <li><a href="#"><i class="fa-solid fa-gear"></i> Configurar</a></li>
                </ul>
            </nav>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function(){
                    $('.expandable').click(function(){
                        $('.submenu').toggle();
                    });
                });

                $(document).ready(function(){
                    $('.expandable').click(function(){
                        setTimeout(function() {
                            $('.submenu').toggle();
                        }, 5000); // 2000 milisegundos = 2 segundos (ajusta según tus necesidades)
                    });
                });

            </script>                  
        </div>
    </header>
    <div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="informacion">
        <div class="container3">
            <!-- Contenedores que parecen botones -->
            <div class="boton1">
                <span>RESUMEN ABRIL 2024</span>
                <i class="fa-solid fa-rectangle-list"></i>
            </div>
    
            <div class="boton2">
                CONSOLIDADO DE ABRIL 2024 
                <i class="fa-solid fa-handshake"></i>
            </div>
    
            <div class="boton3">
                PRODUCCION DIARIA  ABRIL 2024
                <i class="fa-regular fa-calendar"></i>
            </div>
    
            <div class="boton4">
                POSITIVOS ABRIL 2024 FINAL 
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
        </div>
    
        <div class="container4">
            <div class="boton5">
                POSITIVOS ABRIL 2024 FINAL 
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
    
            <div class="boton6">
                ESTADISTICA ABRIL 2024 SAN INGNACIO CUALITATIVA 
                <i class="fa-solid fa-chart-pie"></i>
            </div>
        </div>
    </div>

    <!--	--------------->
    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <div class="imagen-container">
                    <img src="{{ asset('storage/' . Auth::user()->imagen_perfil) }}" class="img" alt="Logo">

                    <h2>{{ Auth::user()->name }}</h2>
                    <h6>SUBOFICIAL</h6>
                </div>              
                <br><br>
                
                <a href="{{ route('home') }}"> <i class="fa-solid fa-house"></i> Inicio</a>
                <a href="{{ route('principal') }}"><i class="fa-solid fa-user-plus"></i> Añadir Usuario</a>
                <a href="{{ route('extraccion') }}"><i class="fa-solid fa-vials"></i> Extracción</a>
                <a href="{{ route('tbl-certificados') }}"> <i class="fa-solid fa-table-list"></i> Tabla certificados</a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </nav>

            <label for="btn-menu"><i class="fa-solid fa-list"></i></label>
        </div>
    </div>
</body>
</html>