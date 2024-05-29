<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Procesamiento</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/procesamiento.css') }}">
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
                    <label  class="expandable" for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}" class="imagen1"> </label>
                    <h3 class="expandable">{{ Auth::user()->name }}</h3>
                    <ul class="submenu">
                        <li id="openModalBtn">
                            <a href="#">
                                <i class="fa-solid fa-users-viewfinder"></i> Cambiar foto
                            </a>
                        </li>
                        <li id="openModalPassword">
                            <a href="#"><i class="fa-solid fa-gear"></i> Configurar</a>
                        </li>
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
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="direccion">
                <h3>Cambiar foto de perfil</h3>
                <span class="close">&times;</span>
            </div>

            <div id="previewContainer">
                <img id="previewImage" src="" alt="Foto">
            </div>
            <form method="POST" action="#" id="imageForm" enctype="multipart/form-data">
                @csrf
                <input type="file" id="imageInput" name="imagen" required>
                <button class="azul" type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <div id="myModalPassword" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <!-- Modal header -->
            <div class="direccion">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Cambiar contraseña
                </h3>
                <span class="close" id="closePassword">&times;</span>
            </div>
            <!-- Modal body -->
            <div class="cambiar-password-form">
                <form method="POST" class="space-y-4" action="{{ route('cambiar-password', ['id' => Auth::user()->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                        <input type="email" name="email" id="email" value={{ Auth::user()->email }} readonly />
                        <i id="arroba" class="fa-solid fa-at"></i>
                    </div>
                    <div class="form-group">
                        <label for="currentPassword" class="password-label"><i class="fas fa-lock"></i> Contraseña actual</label>
                        <input type="password" name="password" id="currentPassword" placeholder="••••••••" required />
                        <i class="fas fa-eye-slash" id="show-password1" onclick="togglePasswordVisibility1()"></i>
                    </div>
                    <div class="form-group">
                        <label for="newPassword"><i class="fas fa-lock"></i> Nueva contraseña</label>
                        <input type="password" name="newPassword" id="newPassword" placeholder="••••••••" required />
                        <i class="fas fa-eye-slash" id="show-password2" onclick="togglePasswordVisibility2()"></i>
                    </div>
                    <div class="form-group">
                        <label for="confirmedPassword"><i class="fas fa-lock"></i> Confirmar contraseña</label>
                        <input type="password" name="confirmedPassword" id="confirmedPassword" placeholder="••••••••" required />
                        <i class="fas fa-eye-slash" id="show-password3" onclick="togglePasswordVisibility3()"></i>
                    </div>
                    <button type="submit" class="bot">Cambiar contraseña</button>    
                </form>
            </div>
        </div>
    </div>
    <!--CONTENIDO-->
    <div class="capa1">
        <form method="POST" action="{{ route('register-procesamiento') }}">
            @csrf
            <div class="titulo-container">
                <h4>INFORMACIÓN GENERAL</h4>
            </div>
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
            @foreach ($elementos as $elemento)
            @if ($elementos)
            <fieldset>
                <legend>Información General</legend>
                
                <div class="input-general">
                    <div class="input-group">
                        <label for="numero_oficio">Número de Oficio de referencia:</label>
                        <input type="text" id="numero_oficio" value="{{ $elemento->recepcion_doc_referencia }}" name="recepcion_doc_referencia" required>
                    </div>
                    <div class="input-group">
                        <label for="procedencia">Procedencia:</label>
                        <input type="text" id="procedencia" name="procedencia" value="{{ $elemento->procedencia }}" required oninput="convertirMayusculas(this)">
                    </div>
                    <div class="input-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" value="{{ $elemento->fecha }}">
                    </div>

                    <div class="input-group">
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora" value="{{ $elemento->hora }}">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Información del Intervenido</legend>
                <div class="input-general1">
                    <div class="input-group1">
                        <label for="dni">DNI:</label>
                        <input type="text" id="dni" name="dni" value="{{ $elemento->dni }}" required oninput="validarDocumento(this)" readonly>
                    </div>
                    <div class="input-group1">
                        <label for="Nombre">Nombre:</label>
                        <input type="text" id="Nombre" name="nombre" value="{{ $elemento->nombre }}" required oninput="validarLetras1(this)">
                    </div>
                    <div class="input-group1">
                        <label for="Apellidopaterno">Apellido paterno:</label>
                        <input type="text" id="Apellidopaterno" name="apellido_paterno" value="{{ $elemento->apellido_paterno }}" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group1">
                        <label for="Apellidomaterno">Apellido materno:</label>
                        <input type="text" id="Apellidomaterno" name="apellido_materno" value="{{ $elemento->apellido_materno }}" required oninput="validarLetras(this)">
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
                        <input type="text" id="nacionalidad" name="nacionalidad" value="{{ $elemento->nacionalidad }}" required oninput="convertirMayusculas(this)">
                    </div>
                    <div class="input-group1">
                        <label for="edad">Edad:</label>
                        <input type="text" id="edad" name="edad" value="{{ $elemento->edad }}" required oninput="validarDocumento(this)" maxlength="2">
                    </div>
                    <div class="input-group1">
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo" required>
                            <option selected disabled>----SELECCIONAR----</option>
                            <option value="M" {{ $elemento->sexo == 'M' ? 'selected' : '' }}>MASCULINO</option>
                            <option value="F" {{ $elemento->sexo == 'F' ? 'selected' : '' }}>FEMENINO</option>
                        </select>
                    </div>

                    <div class="input-group1">
                        <label for="licencia">Licencia:</label>
                        <input type="text" id="licencia" name="licencia" value="{{ $elemento->licencia }}" oninput="convertirMayusculas(this)">
                    </div>

                </div>
                <div class="input-general1">
                    <div class="input-group1">
                        <label for="clase">Clase:</label>
                        <input type="text" id="clase" name="clase" value="{{ $elemento->clase }}" oninput="convertirMayusculas(this)">
                    </div>
                    <div class="input-group1">
                        <label for="categoria">Categoría:</label>
                        <input type="text" id="categoria" name="categoria"  oninput="convertirMayusculas(this)" value="{{ $elemento->categoria }}">
                    </div>
                    <div class="input-group1">
                        <label for="vehiculo">Vehículo:</label>
                        <input type="text" id="vehiculo" name="vehiculo" value="{{ $elemento->vehiculo }}" required oninput="convertirMayusculas(this)">
                    </div>
                    <div class="input-group1">
                        <label for="placa">N° de placa:</label>
                        <input type="text" id="placa" name="placa" value="{{ $elemento->placa }}" oninput="convertirMayusculas(this)" maxlength="20">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Personal Policial Encargado</legend>
                <div class="input-general2">
                    <div class="input-group2">
                        <label for="nombre_policial">Nombre - Apellidos - Grado:</label>
                        <input type="text" id="nombre_policial" name="nombre_policial" value="{{ $elemento->persona }}" required oninput="convertirMayusculas(this)">
                    </div>
                </div>
                <div class="input-general2">
                    <div class="input-group2">
                        <label for="motivo">Motivo:</label>
                        <input type="text" id="motivo" name="motivo" value="{{ $elemento->motivo }}" required oninput="validarLetras(this)">
                    </div>
                    <div class="input-group2">
                        <label for="fecha_hora_infraccion">Fecha y Hora de Infración:</label>
                        <input type="datetime" id="fecha_hora_infraccion" name="fecha_hora_infraccion" value="{{ $elemento->fecha_hora_infraccion }}">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                {{-- Falta --}}
                <legend>Extractor</legend>
                <div class="input-general3">
                    <div class="input-group3">
                        <label for="extractor">Nombre-Grado:</label>
                        <select id="extractor" name="extractor" readonly>
                            <option disabled selected>--SELECCIONAR--</option>
                            @foreach ($personalAreaExtra as $personal)
                                <option value="{{ $personal->persona_id }}"  {{ $personal->persona_id == $elemento->extractor ? 'selected' : '' }}>{{ $personal->Persona->nombre }} {{ $personal->Persona->apellido_paterno }} {{ $personal->Persona->apellido_materno }} - {{ $personal->grado->grado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-general3">
                    <div class="input-group3">
                        <label for="tipo_muestra">Tipo de muestra:</label>
                        <select id="tipo_muestra" name="tipo_muestra" onchange="mostrarCampoOtros()">
                            <option value="SANGRE" {{ $elemento->descripcion == 'SANGRE' ? 'selected' : '' }}>SANGRE</option>
                            <option value="ORINA" {{ $elemento->descripcion == 'ORINA' ? 'selected' : '' }}>ORINA</option>
                            <option value="SIN MUESTRA" {{ $elemento->descripcion == 'SIN MUESTRA' ? 'selected' : '' }}>SIN MUESTRA</option>
                            <option value="otros" {{ $elemento->descripcion == 'otros' ? 'selected' : '' }}>OTROS</option>
                        </select>
                    </div>
                    
                    <div class="input-group3" id="campo_otros" style="display: none;">
                            <label for="otro_tipo_muestra">Especificar otro tipo de muestra:</label>
                            <input type="text" id="otro_tipo_muestra" name="otro_tipo_muestra" oninput="convertirMayusculas(this)">
                    </div>

                    <div class="input-group3">
                        <label for="resultado_cualitativo">Resultado cualitativo:</label>
                        <select id="resultado_cualitativo" name="resultado_cualitativo" onchange="mostrarIncurso()">
                            <option disabled selected>--SELECCIONAR--</option>
                            <option value="positivo" {{ $elemento->resultado_cualitativo == 'positivo' ? 'selected' : '' }}>POSITIVO</option>
                            <option value="negativo" {{ $elemento->resultado_cualitativo == 'negativo' ? 'selected' : '' }}>NEGATIVO</option>
                            <option value="CONSTATACIÓN" {{ $elemento->resultado_cualitativo == 'CONSTATACIÓN' ? 'selected' : '' }}>CONSTATACIÓN</option>
                            <option value="NEGACIÓN" {{ $elemento->resultado_cualitativo == 'NEGACIÓN' ? 'selected' : '' }}>NEGACIÓN</option>
                        </select>
                    </div>

                    <div class="input-group3">
                        <label for="fecha_hora_extraccion">Fecha y Hora de Extracción:</label>
                        <input type="datetime" id="fecha_hora_extraccion" name="fecha_hora_extraccion" value="{{ $elemento->fecha_hora_extraccion }}">
                    </div>

                </div>

                <div class="input-general3">
                    <div class="input-group3">
                        <label for="observaciones">Observaciones:</label>
                        <textarea id="observaciones" name="observaciones" required oninput="convertirMayusculas(this)">
                            {{ $elemento->observaciones }}
                        </textarea>
                    </div>
                </div>
            </fieldset>
            @else
            <p>No se encontraron datos para el DNI proporcionado.</p>
            @endif
            <div class="titulo-container">
                <h4>RESULTADO CUANTITATIVO</h4>
            </div>
            <fieldset>
                <legend>Datos a Ingresar</legend>
                <div class="input-general">
                    <div class="input-group">
                        <label class="centro" for="procesador">DNI - Nombres y Apellidos Completos - Cargo </label>
                        <select id="procesador" name="procesador">
                            <option disabled selected>--SELECCIONAR--</option>
                            <option value="">-----------</option>
                            @foreach ($personalProcesamiento as $personal)
                                <option value="{{ $personal->persona_id }}" @if(isset($personal->Persona)) selected @endif>
                                    @if(isset($personal->Persona))
                                        {{ $personal->Persona->nombre }} {{ $personal->Persona->apellido_paterno }} {{ $personal->Persona->apellido_materno }} - {{ $personal->grado->grado }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-general1">
                    <div class="input-group1">
                        <label for="numeroDecimal">Resultado (g/L):</label>
                        <input type="text" id="numeroDecimal" oninput="validarEntrada(this)" onchange="convertirNumeroALetras()" name="resultado_cuantitativo"  value="{{ $elemento->resultado_cuantitativo ?? '' }}" maxlength="4">
                    </div>
                    <div class="input-group" id="modificar"style="display: none;">
                        <label for="incurso">Incurso:</label>
                        <select id="incurso" name="incurso">
                            <option value="" selected disabled>--SELECCIONAR--</option>
                            <option value="1">M.1</option>
                            <option value="2">M.2</option>
                        </select>
                    </div>
                    <div class="input-group1">
                        <label for="resultado"></label>
                        <textarea id="resultado" name="resultado_cuantitativo_letra" readonly></textarea> 
                    </div>
                </div>

                <div class="input-general1">
                    <div class="input-group1">
                        <label for="conclusiones">Conclusiones:</label>
                        <input type="text" id="conclusiones" name="conclusiones" oninput="convertirMayusculas(this)" value="{{$elemento->conclusiones ?? '' }}">
                    </div>
                </div>
            </fieldset>
            @endforeach
            <div class="almacenar">
                <div class="Actualizar">
                    <button type="submit">Actualizar Informacion</button>
                </div>
                <div class="Enviar">
                    <button type="reset">Cancelar</button>
                </div>
                <script src="{{ asset('js/importante.js') }}"></script>
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
                    <h5 class="text-white">{{ Auth::user()->name }}</h5>
                </div>              
                <br>
                <a href="{{ route('home') }}"> <i class="fa-solid fa-house"></i> Inicio</a>
                <a href="{{ route('principal') }}"> <i class="fa-solid fa-user-plus"></i> Añadir usuario</a>
                <a href="{{ route('listar-usuarios') }}"><i class="fa-solid fa-list"></i> Listar Usuarios</a>
                <a href="{{ route('tbl-certificados') }}"> <i class="fa-solid fa-table-list"></i> Certificados</a>
                <a href="{{ route('extraccion')}}"><i class="fa-solid fa-vials"></i> Extracción</a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Seción</a>
            </nav>
            <label for="btn-menu"><i class="fa-solid fa-list"></i></label>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener el modal y el botón para abrirlo
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("openModalBtn");
            var span = document.getElementsByClassName("close")[0];
            var mainImage = document.getElementById("mainImage");

            var modalPassword = document.getElementById("myModalPassword");
            var btnPassword = document.getElementById("openModalPassword");
            var closePassword = document.getElementById("closePassword");

            var savedImage = sessionStorage.getItem("selectedImage");
            if (savedImage) {
                mainImage.src = savedImage;
            }
    
            // Abrir el modal al hacer clic en el botón
            btn.onclick = function () {
                modal.style.display = "block";
            }

            btnPassword.onclick=() => {
                modalPassword.style.display = "block";
            }
    
            // Cerrar el modal al hacer clic en la "x"
            span.onclick = function () {
                modal.style.display = "none";
            }

            closePassword.onclick = () => {
                modalPassword.style.display = "none";
            }
    
            // Cerrar el modal al hacer clic fuera del contenido del modal
            window.onclick = function (event) {
                if (event.target == modal || event.target == modalPassword) {
                    modal.style.display = "none";
                    modalPassword.style.display = "none";
                }
            }
    
            // Previsualizar la imagen seleccionada antes de guardarla
            var imageInput = document.getElementById("imageInput");
            var previewImage = document.getElementById("previewImage");
            imageInput.addEventListener("change", function () {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
    
            // Enviar el formulario para guardar la imagen
            var form = document.getElementById("imageForm");
            form.onsubmit = function (event) {
                event.preventDefault();
                var formData = new FormData(form);
                fetch("{{ route('cambiar-imagen', ['id' => Auth::user()->id]) }}", {
                    method: "POST",
                    body: formData
                })
                .then(data => {
                    // alert(data.message);
                    modal.style.display = "none";
                    previewImage.src = "";
                    mainImage.src = data.imageUrl;
                    sessionStorage.setItem("selectedImage", data.imageUrl);
                    
                    
                })
                .catch(error => {
                    console.error("Error al guardar la imagen:", error);
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        });
    </script>
</body>
</html>