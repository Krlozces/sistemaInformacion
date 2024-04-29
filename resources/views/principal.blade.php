<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> --}}
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('js/importante.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
</head>

<body>
    @include('modalCambiarFoto')
    <header class="header">
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu" > <img src="{{ asset('images/logo.png') }}" class="imagen"> </label>
            </div>
            <div class="flex justify-between">
                <div class="logo w-[70%]">
                    <h1>Dosaje Etílico</h1>
                </div>
                <nav class="flex justify-between w-[20%] items-center relative">
                    <div for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}" class="w-1/2 rounded-full"> </div>
                    <h3 class="expandable">{{ Auth::user()->name }}</h3>
                    <ul class="submenu">
                        <li><a data-modal-target="modalCambiarImagen-{{ Auth::user()->id }}" data-modal-toggle="modalCambiarImagen-{{ Auth::user()->id }}"><i class="fa-solid fa-users-viewfinder"></i> Cambiar foto</a></li>
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
    
                </script>
            </div>                  
        </div>
    </header>
    <!--CONTENIDO-->
    <div class="capa1">
        <form method="POST" action="{{ route('register-personal') }}" enctype="multipart/form-data">
            @csrf
            <div class="titulo">
                <h4>Registro del Personal de la Unidad Desconcentrada de Dosaje Etílico</h4>
            </div>
            <fieldset>
                <legend>Datos Personales</legend>
                    <div class="input-general">
                    <div class="input-group">
                        <label for="dni">Documento de Identidad (DNI):</label>
                        <input type="text" id="dni" name="dni" required oninput="validarDocumento(this)">    
                    </div>
                    <div class="input-group">
                        <label for="nombre">Nombres Completos:</label>
                        <input type="text" id="nombre" name="nombre" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group">
                        <label for="apellidoPaterno">Apellido Paterno:</label>
                        <input type="text" id="apellidoPaterno" name="apellido_paterno" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group">
                        <label for="apellidoMaterno">Apellido Materno:</label>
                        <input type="text" id="apellidoMaterno" name="apellido_materno" required oninput="validarLetras(this)">
                    </div>
                
                    <script>
                        $('#dni').change(function() {
                        dni = $('#dni').val();
                        $.ajax({
                            url: "{{ asset('Controlador/consultarApi.php') }}",
                            type: "post",
                            data: `dni=${dni}`,
                            dataType: "json",
                            success: function(r) {
                                if (r.numeroDocumento == dni) {
                                    // Manejar la respuesta de la api
                                    $("#apellidoPaterno").val(r.apellidoPaterno);
                                    $("#apellidoMaterno").val(r.apellidoMaterno);
                                    $("#nombre").val(r.nombres);
                                    console.log(r);
                                } else {
                                    console.error(r.error);
                                }
                            },
                            error: function() {
                                console.error("Hubo un error al realizar la llamada AJAX");
                            }
                        });
                    });
                    </script>
                </div>
            
                <div class="input-general1">
                    <div class="input-group1">
                        <label for="genero">Sexo:</label>
                        <select id="genero" name="genero" required>
                            <option selected disabled>----SELECCIONAR----</option>
                            <option value="M">MASCULINO</option>
                            <option value="F">FEMENINO</option>
                        </select>
                    </div>

                    <div class="input-group1">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" required maxlength="9" oninput="validarTelefono(this)">
                        
                    </div>
                    <div class="input-group2">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" required oninput="convertirMayusculas(this)">
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Información Laboral</legend>
                <div class="input-general5">
                    <div class="input-group5">
                        <label for="unidad_perteneciente">Unidad Perteneciente:</label>
                        <input type="text" id="unidad_perteneciente" name="unidad_perteneciente" value="UNIDDE" readonly required>                        
                    </div>
                    <div class="input-group5">
                        <label for="grado">Grado del Personal:</label>
                        <select id="grado" name="grado" required>
                            <option selected disabled>----SELECCIONAR----</option>
                            <option value="SubOficial">SUBOFICIAL</option>
                            <option value="Mayor">MAYOR</option>
                        </select>
                    </div>
    
                    <div class="input-group5">
                        <label for="area_perteneciente">Área Preteneciente:</label>
                        <select id="area_perteneciente" name="area_perteneciente" required>
                            <option disabled selected>----SELECCIONAR----</option>
                            <option value="areaextra">AREA DE EXTRACCIÓN</option>
                            <option value="areapro">AREA DE PROCESAMIENTO</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Credenciales de Acceso</legend>
                <div class="input-general5">
                    <div class="input-group5">
                        <label for="usuario">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" required>
                    </div>

                    <div class="input-group5">
                        <label for="password">Contraseña:</label><br><br>
                        <div  class="password-container">
                            <input type="password" id="password" name="password" required>
                            <i class="fas fa-eye-slash" id="show-password" onclick="togglePasswordVisibility()"></i>
                        </div>
                    </div>

                    <div class="input-group5">
                        <label for="image">Imagen:</label><br><br>
                        <input type="file" name="imagen" id="image" />
                    </div>
                </div>
            </fieldset>
            
            <div class="almacenar">
                <div class="Actualizar">
                    <button type="submit">Registrar</button>
                </div>
                <div class="Enviar">
                    <button type="reset">Cancelar</button>
                </div>
            </div>

            </div>
        </form>
    </div>
    
    <!--	--------------->
    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <div class="imagen-container flex flex-col justify-center items-center">
                    <img src="{{ asset('storage/' . Auth::user()->imagen_perfil) }}" class="img" alt="Logo">

                    <h2>{{ Auth::user()->name }}</h2>
                    <h6>SUBOFICIAL</h6>
                </div>                              
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