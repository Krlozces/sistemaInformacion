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
        {{-- <div class="container">
            <div class="btn-menu">
                <label for="btn-menu"> <img src="{{ asset('images/logo.png') }}" class="imagen"> </label>
            </div>
            <div class="flex justify-between">
                <div class="logo w-[70%]">
                    <h1>UNIDDE</h1>
                </div>
                <nav class="menu">
                    <label for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}"
                            class="imagen1"> </label>
                    <h3 class="expandable">{{ Auth::user()->name }}</h3>
                    <ul class="submenu">
                        <li id="openModalBtn"><a href="#"><i class="fa-solid fa-users-viewfinder"></i> Cambiar foto</a>
                        </li>
                        <li id="openModalPassword"><a href="#"><i class="fa-solid fa-gear"></i> Configurar</a></li>
                    </ul>
                </nav>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $('.expandable').click(function () {
                            $('.submenu').toggle();
                        });
                    });

                </script>
            </div>
        </div> --}}
    </header>
    {{-- <div id="myModal" class="modal">
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
    </div> --}}
    <!--CONTENIDO-->
    <div class="advertencia">
        <div class="boton">
            <!-- Imagen a la izquierda y texto a la derecha -->
            <img src="{{ asset('images/noautorizado.png') }}" alt="NoAutorizado">
            <span>Lo siento, no tienes permiso para acceder a esta página. <br>Por favor, <a href="">Inicia Sesión</a>
                con otra cuenta para acceder a esta página.</span>
        </div>
    </div>

    {{-- <div id="myModalPassword" class="modal">
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
                <form method="POST" class="space-y-4"
                    action="{{ route('cambiar-password', ['id' => Auth::user()->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                        <input type="email" name="email" id="email" value={{ Auth::user()->email }} readonly />
                        <i id="arroba" class="fa-solid fa-at"></i>
                    </div>
                    <div class="form-group">
                        <label for="currentPassword" class="password-label"><i class="fas fa-lock"></i> Contraseña
                            actual</label>
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
                        <input type="password" name="confirmedPassword" id="confirmedPassword" placeholder="••••••••"
                            required />
                        <i class="fas fa-eye-slash" id="show-password3" onclick="togglePasswordVisibility3()"></i>
                    </div>
                    <button type="submit" class="bot">Cambiar contraseña</button>
                </form>
            </div>
        </div>
    </div> --}}

    <!--	--------------->
    {{-- <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <div class="imagen-container flex flex-col justify-center items-center">
                    <img src="{{ asset('storage/' . Auth::user()->imagen_perfil) }}" class="img" alt="Logo">

                    <h2>{{ Auth::user()->name }}</h2>
                    <h6>{{ $grado ? $grado->grado : '' }}</h6>
                </div>
                <a href="{{ route('home') }}"> <i class="fa-solid fa-house"></i> Inicio</a>
                <a href="{{ route('principal') }}"><i class="fa-solid fa-user-plus"></i> Añadir Usuario</a>
                <a href="{{ route('listar-usuarios') }}"><i class="fa-solid fa-list"></i> Listar Usuarios</a>
                <a href="{{ route('extraccion') }}"><i class="fa-solid fa-vials"></i> Extracción</a>
                <a href="{{ route('tbl-certificados') }}"> <i class="fa-solid fa-table-list"></i> Tabla certificados</a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </nav>

            <label for="btn-menu"><i class="fa-solid fa-list"></i></label>
        </div>
    </div> --}}
    <script async defer>
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

            btnPassword.onclick = () => {
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