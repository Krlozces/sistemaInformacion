<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla certificados</title>
    <link rel="icon" href="'images/logo.png'">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/importante.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/listausuarios.css') }}">
    <style>
        tr:hover {
            background-color: lightblue;
            /* Cambia de color al pasar el cursor sobre una fila */
        }

        #mensajeRegistros {
            display: none; /* Inicialmente oculto */
            background-color: white;
            padding: 10px;
            margin-top: 0px; /* Espacio arriba del mensaje */
            border: 1px solid #ccc; /* Borde del mensaje */
            width: calc(100% ); /* Ancho igual al de la tabla menos el borde */
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="btn-menu">
                <label for="btn-menu"> <img src="{{ asset('images/logo.png') }}" class="imagen"> </label>
            </div>
            <div class="logo">
                <h1>Dosaje Etílico</h1>
            </div>
            <nav class="menu">
                <label for="btn-menu1"> <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}"
                        class="imagen1"> </label>
                <h3 class="expandable">{{ Auth::user()->name }}</h3>
                <ul class="submenu">
                    <li id="openModalBtn"><a href="#"><i class="fa-solid fa-users-viewfinder"></i> Cambiar foto</a></li>
                    <li><a href="#"><i class="fa-solid fa-gear"></i> Configurar</a></li>
                </ul>
            </nav>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.expandable').click(function() {
                        $('.submenu').toggle();
                    });
                });

                $(document).ready(function() {
                    $('.expandable').click(function() {
                        setTimeout(function() {
                            $('.submenu').toggle();
                        }, 5000);
                    });
                });
            </script>
        </div>
    </header>
    
    <div id="popup-modal" class="modal">
        <div class="modal-content">
            <div class="direccion">
                <h3>Eliminar usuario</h3>
                <span class="close" id="closeModal">&times;</span>
            </div>
            <div class="icon-contenedor">
                <svg class="svg-contenedor" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="message">¿Estás seguro de inhabilitar al siguiente usuario?</h3>
                <button data-modal-hide="popup-modal" type="button" class="btn-confirmed">
                    Sí, estoy seguro
                </button>
                <button id="btn-cancel" data-modal-hide="popup-modal" type="button" class="btn-cancel">No, cancelar</button>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="direccion" id="closeEdit">
                <h3>Editar</h3>
                <span class="close">&times;</span>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form class="space-y-4" action="#">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                    </div>
                    <div class="flex justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                            </div>
                            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</button>
                </form>
            </div>
        </div>
    </div> 

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

    <div class="capa1">
        <div class="titulo-container">
            <h4>Gestión de Certificados</h4>
            <button id="btnexel"><a id="letras" href="#"><i id="exel"
                class="fa-solid fa-file-excel"></i> Importar</a></button>
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

        <table id="dataTable">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Grado</th>
                    <th>Teléfono</th>
                    <th>Extracion</th>
                    <th>Procesamiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="content1">
                @foreach ($elements as $element)
                    <tr>
                        <td>
                            {{ $element->dni }}
                        </td>
                        <td>
                            {{ $element->nombre }}
                        </td>
                        <td>
                            {{ $element->apellido_paterno }}
                        </td>
                        <td>
                            {{ $element->apellido_materno }}
                        </td>
                        <td>
                            {{ $element->grado }}
                        </td>
                        <td>
                            {{ $element->telefono }}
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" id="interruptor" onclick="toggleInterruptor()">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" id="interruptor" onclick="toggleInterruptor()">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td class="btn-container">
                            <button id="editar" onclick="editEntry()"><a href="#"><i class="fa-solid fa-pen-to-square"></i> Editar</a></button>
                            <button id="eliminar"><a href="#"><i class="fa-solid fa-trash"></i> Eliminar</a></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable({
                    searching: true,
                    paging: true
                });
            });
        </script>
    </div>


    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) { // Empezar desde 1 para omitir la fila de encabezados
                var found = false;
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length - 1; j++) { // Iterar hasta td.length - 1 para excluir la columna de acciones
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        function editEntry() {
            console.log("Editar entrada");
        }

        function deleteEntry() {
            console.log("Eliminar entrada");
        }

        // Verificar el estado guardado en localStorage al cargar la página
        window.onload = function () {
            let estadoGuardado = localStorage.getItem('interruptorEstado');
            if (estadoGuardado === 'encendido') {
                document.getElementById('interruptor').checked = true;
                console.log('Interruptor encendido');
            } else {
                document.getElementById('interruptor').checked = false;
                console.log('Interruptor apagado');
            }
        };

        function toggleInterruptor() {
            let interruptor = document.getElementById('interruptor');
            if (interruptor.checked) {
                // Guardar estado encendido en localStorage
                localStorage.setItem('interruptorEstado', 'encendido');
                console.log('Interruptor encendido');
            } else {
                // Guardar estado apagado en localStorage
                localStorage.setItem('interruptorEstado', 'apagado');
                console.log('Interruptor apagado');
            }
        }
    </script>

    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <div class="imagen-container">
                    <img src="{{ asset('storage/' . Auth::user()->imagen_perfil) }}" class="img" alt="Logo">
                    <h2>{{ Auth::user()->name }}</h2>
                    <h6>{{ $grado ? $grado->grado : '' }}</h6>
                </div> 
                <br>
                <a href="{{ route('home') }}"> <i class="fa-solid fa-house"></i> Inicio</a>
                <a href="{{ route('principal') }}"><i class="fa-solid fa-user-plus"></i> Añadir Usuario</a>
                <a href="{{ route('listar-usuarios') }}"><i class="fa-solid fa-list"></i> Listar Usuarios</a>
                <a href="{{ route('extraccion') }}"><i class="fa-solid fa-vials"></i> Extracción</a>
                <a href="{{ route('tbl-certificados') }}"> <i class="fa-solid fa-table-list"></i> Tabla certificados</a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </nav>

            <label for="btn-menu"><i class="fa-solid fa-list"></i></label>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Obtener el modal y el botón para abrirlo
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];
        var mainImage = document.getElementById("mainImage");


        var popUpModal = document.getElementById("popup-modal");
        var btnModal = document.getElementById("eliminar");
        var closeModal = document.getElementById("closeModal");
        var btnCancel = document.getElementById('btn-cancel');

        var editModal = document.getElementById("edit-modal");
        var btnEdit = document.getElementById("editar");
        var closeEdit = document.getElementById("closeEdit");
        var btnCancelEdit = document.getElementById('btn-cancel-edit');

        var savedImage = sessionStorage.getItem("selectedImage");
        if (savedImage) {
            mainImage.src = savedImage;
        }

        // Abrir el modal al hacer clic en el botón
        btn.onclick = function () {
            modal.style.display = "block";
        }

        btnModal.onclick=() => {
            popUpModal.style.display = "block";
        }

        btnEdit.onclick = () => {
            editModal.style.display = "block";
        }

        // Cerrar el modal al hacer clic en la "x"
        span.onclick = function () {
            modal.style.display = "none";
        }

        closeModal.onclick = () => {
            popUpModal.style.display = "none";
        }

        closeEdit.onclick = () => {
            editModal.style.display = "none";
        }

        btnCancel.onclick=() => {
            popUpModal.style.display = "none";
        }

        // Cerrar el modal al hacer clic fuera del contenido del modal
        window.onclick = function (event) {
            if (event.target == modal || event.target == popUpModal || event.target == editModal) {
                modal.style.display = "none";
                popUpModal.style.display = "none";
                editModal.style.display = "none";
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

</html>