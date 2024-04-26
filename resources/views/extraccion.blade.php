<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Área de Extracción</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        <link rel="icon" href="{{ asset('images/logo.png') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="{{asset('js/importante.js')}}"></script>
        <link rel="stylesheet" href="{{ asset('css/extraccion.css') }}">
    </head>
    <body>
        @include('modalCambiarFoto')
        <header class="header">
            <div class="container">
            <div class="btn-menu">
                <label for="btn-menu" > <img src="{{ asset('images/logo.png') }}" class="imagen"> </label>
            </div>
                <div class="logo">
                    <h1>Dosaje Etílico</h1>
                </div>
                <nav class="menu">
                    <label  for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}" class="imagen1"> </label>
                    <h3 class="expandable">{{ Auth::user()->name }}</h3>
                    <ul class="submenu">
                        <li><button data-modal-target="modalCambiarImagen-{{ Auth::user()->id }}" data-modal-toggle="modalCambiarImagen-{{ Auth::user()->id }}"><i class="fa-solid fa-users-viewfinder"></i> Cambiar foto</button></li>
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
        </header>
        
        <!--CONTENIDO-->
    <div class="capa1">
        <form action="{{ route('register-extraccion') }}" method="POST">
            @csrf
            <input type="hidden" name="descripcion" id="descripcion" value="SHEFTELL MODIFICADO PARA FOTOCOLORIMETRIA">
            <div class="titulo-container">
                <h4>INFORMACIÓN GENERAL</h4>
            </div>
            
            <div class="input-general">
                <div class="input-group">   
                    <input class="codigo" type="text" id="codigo" name="codigo" required oninput="validarDocumento1(this)">
                </div>
            </div>

            <fieldset>
                <legend>Información General</legend>
                <div class="input-general">
                    <div class="input-group">
                        <label for="numero_oficio">Número de Oficio de referencia:</label>
                        <input type="text" id="numero_oficio" name="recepcion_doc_referencia" required oninput="validarDocumento(this)">
                    </div>
                    <div class="input-group">
                        <label for="procedencia">Procedencia:</label>
                        <input type="text" id="procedencia" name="procedencia" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha">
                    </div>

                    <div class="input-group">
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Información del Intervenido</legend>
                <div class="input-general1">
                    <div class="input-group1">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" required oninput="validarDocumento(this)">
                    </div>
                    <div class="input-group1">
                        <label for="Nombre">Nombre:</label>
                        <input type="text" id="Nombre" name="nombre" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group1">
                        <label for="Apellidopaterno">Apellido paterno:</label>
                        <input type="text" id="Apellidopaterno" name="apellido_paterno" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group1">
                        <label for="Apellidomaterno">Apellido materno:</label>
                        <input type="text" id="Apellidomaterno" name="apellido_materno" required oninput="validarLetras(this)">
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
                                    $("#Apellidopaterno").val(r.apellidoPaterno);
                                    $("#Apellidomaterno").val(r.apellidoMaterno);
                                    $("#Nombre").val(r.nombres);
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
                        <label for="nacionalidad">Nacionalidad:</label>
                        <input type="text" id="nacionalidad" name="nacionalidad" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group1">
                        <label for="edad">Edad:</label>
                        <input type="text" id="edad" name="edad" required oninput="validarDocumento(this)" maxlength="2">
                    </div>

                    <div class="input-group1">
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" required>
                            <option selected disabled>----SELECCIONAR----</option>
                            <option value="M">MASCULINO</option>
                            <option value="F">FEMENINO</option>
                        </select>
                    </div>


                    <div class="input-group1">
                        <label for="licencia">Licencia:</label>
                        <input type="text" id="licencia" name="licencia" oninput="convertirMayusculas(this)">
                    </div>


                </div>
                <div class="input-general1">
                    <div class="input-group1">
                        <label for="clase">Clase:</label>
                        <input type="text" id="clase" name="clase" oninput="validarLetras(this)" maxlength="1">
                    </div>
                    <div class="input-group1">
                        <label for="categoria">Categoría:</label>
                        <input type="text" id="categoria" name="categoria" oninput="validarLetras(this)" maxlength="4">
                    </div>
                    <div class="input-group1">
                        <label for="vehiculo">Vehículo:</label>
                        <input type="text" id="vehiculo" name="vehiculo" oninput="validarLetras(this)">
                    </div>
                    <div class="input-group1">
                        <label for="placa">N° de placa:</label>
                        <input type="text" id="placa" name="placa" maxlength="20" oninput="convertirMayusculas(this)">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Personal Policial Encargado</legend>
                <div class="input-general2">
                    <div class="input-group2">
                        <label for="nombre_policial">Nombre - Apellidos - Grado:</label>
                        <input type="text" id="nombre_policial" name="nombre_policial" required oninput="convertirMayusculas(this)">
                    </div>

                </div>
                <div class="input-general2">
                    <div class="input-group2">
                        <label for="motivo">Motivo:</label>
                        <input type="text" id="motivo" name="motivo" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group2">
                        <label for="hora_infraccion">Hora de Infración:</label>
                        <input type="time" id="hora_infraccion" name="hora_infraccion">
                    </div>
                    <div class="input-group2">
                        <label for="fecha_infraccion">Fecha de Infracción:</label>
                        <input type="date" id="fecha_infraccion" name="fecha_infraccion">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Extractor</legend>
                <div class="input-general3">
                    <div class="input-group3">
                        <label for="extractor">Nombre-Grado:</label>
                        <select id="extractor" name="extractor">
                            <option disabled selected>--SELECCIONAR--</option>
                            @foreach ($personalAreaExtra as $personal)
                                <option value="{{ $personal->persona_id }}">{{ $personal->Persona->nombre }} {{ $personal->Persona->apellido_paterno }} {{ $personal->Persona->apellido_materno }} - {{ $personal->grado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-general3">
                    <div class="input-group3">
                        <label for="tipo_muestra">Tipo de muestra:</label>
                        <select id="tipo_muestra" name="tipo_muestra" onchange="mostrarOtrosCampos()">
                            <option value="">--SELECCIONAR--</option>
                            <option value="SANGRE">SANGRE</option>
                            <option value="ORINA">ORINA</option>
                            <option value="SIN MUESTRA">SIN MUESTRA</option>
                            <option value="otros">OTROS</option>
                        </select>
                    </div>
                    
                    <div class="input-group3" id="campo_otros" style="display: none;">
                            <label for="otro_tipo_muestra">Especificar otro tipo de muestra:</label>
                            <input type="text" id="otro_tipo_muestra" name="otro_tipo_muestra" oninput="validarLetras(this)">
                    </div>

                    <div class="input-group3">
                        <label for="resultado_cualitativo">Resultado cualitativo:</label>
                        <select id="resultado_cualitativo" name="resultado_cualitativo">
                            <option value="">--SELECCIONAR--</option>
                            <option value="positivo">POSITIVO</option>
                            <option value="negativo">NEGATIVO</option>
                        </select>
                    </div>

                    <div class="input-group3">
                        <label for="hora_extraccion">Hora de Extracción:</label>
                        <input type="time" id="hora_extraccion" name="hora_extraccion">
                    </div>

                </div>

                <div class="input-general3">

                    <div class="input-group3">
                        <label for="fecha_extraccion">Fecha de Extracción:</label>
                        <input type="date" id="fecha_extraccion" name="fecha_extraccion">
                    </div>

                    <div class="input-group3">
                        <label for="observaciones">Observaciones:</label>
                        <input type="text" id="observaciones" name="observaciones" required oninput="validarLetras(this)">
                    </div>
                </div>
            </fieldset>

            <div class="almacenar">
                <div class="Actualizar">
                    <button type="submit">Actualizar Informacion</button>
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
                <div class="imagen-container">
                    <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}" class="img" alt="Logo">
                    <h1>{{ Auth::user()->name }}</h1>
                </div>              
                <br><br>              

                <a href="{{ route('home') }}"> <i class="fa-solid fa-house"></i> Inicio</a>
                <a href="{{ route('principal') }}"><i class="fa-solid fa-circle-info"></i> Añadir Usuario</a>
                <a href="{{ route('extraccion') }}"><i class="fa-solid fa-chart-pie"></i> Extracción</a>
                <a href="{{ route('tbl-certificados') }}"> <i class="fa-solid fa-user-tie"></i>Tabla certificados</a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </nav>

            <label for="btn-menu"><i class="fa-solid fa-list"></i></label>
        </div>
    </div>
    </body>
    </html>