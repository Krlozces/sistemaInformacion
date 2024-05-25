{{-- @extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
    
    <style>
        /* Estilo para el contenedor de información */
        .advertencia {
            margin: 10% 0px;
            padding: 2% 1%;
            border: 1px solid #bae0d1;
            background-color: #bae0d1;
        }

        /* Estilo para los contenedores */

        /* Estilo para el contenedor del botón */
        .boton {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin: 10% 10%;
            border: 5px solid #ff2727;
            background-color: #ffc7c7;
            color: #480707;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
        }

        /* Estilo para la imagen dentro del botón */
        .boton img {
            margin-right: 20px;
            max-width: 15%;
            height: auto;
            border-radius: 3px;
        }

        /* Estilo para el texto dentro del botón */
        .boton span {
            font-weight: bold;
            color: #330000;
            font-size: 20px;
        }

        a {
            text-decoration: none;
            color: #0059ff;
        }

        a:hover {
            color: #1494ff;
        }

        /* Media queries para responsive design */

        /* Para pantallas pequeñas (teléfonos móviles) */
        @media (max-width: 600px)  {
            .boton {
                flex-direction: column;
                margin: 33% 5%;
                padding: 10px;
            }

            .boton img {
                margin-right: 0;
                margin-bottom: 10px;
                max-width: 30%;
            }

            .boton span {
                font-size: 16px;
            }

            .advertencia {
                margin: 10% 0;
                padding: 5% 2%;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu"><a href="{{ route('home') }}"> <img src="{{ asset('images/logo.png') }}" class="imagen"></a> </label>
            </div>
            <div class="flex justify-between">
                <div class="logo w-[70%]">
                    <h1>UNIDDE</h1>
                </div>
                <nav class="menu">
                    <label for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}"
                            class="imagen1"> </label>
                    <h3 class="expandable">{{ Auth::user()->name }}</h3>
                </nav>
            </div>
        </div>
    </header>
    <!--CONTENIDO-->
    <div class="advertencia">
        <div class="boton">
            <img src="{{ asset('images/noautorizado.png') }}" alt="NoAutorizado">
            <span>Lo siento, no tienes permiso para acceder a esta página. <br>Por favor, <a href="">Inicia Sesión</a>
                con otra cuenta para acceder a esta página.</span>
        </div>
    </div>
</body>

</html>