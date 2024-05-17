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
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
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
                        <label for="password" class="password-label"><i class="fas fa-lock"></i> Contraseña actual</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" required />
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
    
    <div class="informacion">
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
        <div class="container3">
            <!-- Contenedores que parecen botones -->
            <div class="boton1">
                RESUMEN ABRIL 2024
                <a href="{{ route('exportar-consolidado') }}">
                    <i class="fa-solid fa-rectangle-list"></i>
                </a>
            </div>
    
            <div class="boton2">
                SEGUN RESULTADOS
                <a href="#">
                    <i class="fa-solid fa-handshake"></i>
                </a>
            </div>
    
            <div class="boton3">
                SEGUN MOTIVOS
                <a href="#">
                    <i class="fa-regular fa-calendar"></i>
                </a>
            </div>
    
            <div class="boton4">
                SEGUN MUESTRAS
                <a href="#">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                </a>
            </div>
        </div>
    
        <div class="container4">
            <div class="boton5">
                SEGUN EDAD
                <a href="#">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                </a>
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
                    <h6>{{ $grado ? $grado->grado : '' }}</h6>
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

        function togglePasswordVisibility1() {
            const passwordInput = document.getElementById("password");
            const showPasswordIcon = document.getElementById("show-password1");
            if (passwordInput.getAttribute("type") === "password") {
                passwordInput.setAttribute("type", "text");
                showPasswordIcon.classList.remove("fa-eye-slash");
                showPasswordIcon.classList.add("fa-eye");
            } else {
                passwordInput.setAttribute("type", "password");
                showPasswordIcon.classList.remove("fa-eye");
                showPasswordIcon.classList.add("fa-eye-slash");
            }
        }

        function togglePasswordVisibility2() {
            const newPasswordInput = document.getElementById("newPassword");
            const showPasswordIcon = document.getElementById("show-password2");
            if (newPasswordInput.getAttribute("type") === "password") {
                newPasswordInput.setAttribute("type", "text");
                showPasswordIcon.classList.remove("fa-eye-slash");
                showPasswordIcon.classList.add("fa-eye");
            } else {
                newPasswordInput.setAttribute("type", "password");
                showPasswordIcon.classList.remove("fa-eye");
                showPasswordIcon.classList.add("fa-eye-slash");
            }
        }

        function togglePasswordVisibility3() {
            const confirmedPasswordInput = document.getElementById("confirmedPassword");
            const showPasswordIcon = document.getElementById("show-password3");        
            if (confirmedPasswordInput.getAttribute("type") === "password") {
                confirmedPasswordInput.setAttribute("type", "text");
                showPasswordIcon.classList.remove("fa-eye-slash");
                showPasswordIcon.classList.add("fa-eye");
            } else {
                confirmedPasswordInput.setAttribute("type", "password");
                showPasswordIcon.classList.remove("fa-eye");
                showPasswordIcon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>