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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

        .label-text{
            display: block; 
            margin-bottom: 0.5rem; 
            color: #111827; 
            font-size: 0.875rem;
            line-height: 1.25rem; 
            font-weight: 500; 
        }

        .input-field{
            display: block; 
            padding: 0.625rem; 
            background-color: #F9FAFB; 
            color: #111827; 
            font-size: 0.875rem;
            line-height: 1.25rem; 
            width: 100%; 
            border-radius: 0.5rem; 
            border-width: 1px; 
            border-color: #D1D5DB; 
            outline: none;
            margin-bottom: 20px;
        }

        .btn-editar{
            padding-top: 0.625rem;
            padding-bottom: 0.625rem; 
            padding-left: 1.25rem;
            padding-right: 1.25rem; 
            background-color: #1D4ED8; 
            color: #ffffff; 
            font-size: 0.875rem;
            line-height: 1.25rem; 
            font-weight: 500; 
            text-align: center; 
            width: 100%; 
            border-radius: 0.5rem; 
            border:none;
        }

        .btn-editar:hover {
            background-color: #1E40AF; 
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
            <h4>Gestión del Personal</h4>
            <button id="btnexel">
                <a id="letras" href="{{ route('exportar-personal') }}"><i id="exel"
                class="fa-solid fa-file-excel"></i> Exportar</a>
            </button>
        </div>

        @if (session('success'))
            <script>
                swal("Buen trabajo!", "Registro exitoso!", "success");
            </script>
        @endif
        @if (session('error'))
            <script>
                swal("Oooops!", "Ocurrió un error!", "error");
            </script>
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
                    <div id="edit-modal-{{$element->dni}}" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="direccion" id="closeEdit" onclick="closeEdit({{ $element->dni }})">
                                <h3>Editar</h3>
                                <span class="close">&times;</span>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5">
                                <form class="space-y-4" action="{{ route('editar-usuario', ['dni' => $element->dni]) }}" method="POST">
                                    @csrf
                                    <div>
                                        <label for="dni" class="label-text">DNI</label>
                                        <input type="text" name="dni" id="dni" class="input-field" value="{{ $element->dni }}" required />
                                    </div>
                                    <div>
                                        <label for="nombre" class="label-text">Nombres</label>
                                        <input type="text" name="nombre" id="nombre" class="input-field" value="{{ $element->nombre }}" required />
                                    </div>
                                    <div>
                                        <label for="apellido_paterno" class="label-text">Apellido paterno</label>
                                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="input-field" value="{{ $element->apellido_paterno }}" required />
                                    </div>
                                    <div>
                                        <label for="apellido_materno" class="label-text">Apellido materno</label>
                                        <input type="text" name="apellido_materno" id="apellido_materno" class="input-field" value="{{ $element->apellido_materno }}" required />
                                    </div>
                                    <div>
                                        <label for="grado" class="label-text">Grado</label>
                                        <select name="grado" id="grado" class="input-field">
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}" {{ $grade->id == $element->id ? 'selected' : '' }}>
                                                    {{ $grade->grado }}
                                                </option>
                                            @endforeach
                                            {{-- <option value="{{ $element->grado }}">{{}}</option> --}}
                                        </select>
                                    </div>
                                    <div>
                                        <label for="telefono" class="label-text">Teléfono</label>
                                        <input type="tel" name="telefono" id="telefono" class="input-field" value="{{ $element->telefono }}" required />
                                    </div>
                                    <button type="submit" class="btn-editar">Editar</button>
                                </form>
                            </div>
                        </div>
                    </div> 
                    <div id="popup-modal-{{ $element->dni }}" class="modal">
                        <div class="modal-content">
                            <div class="direccion" onclick="closeDelete({{ $element->dni }})">
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
                                <button id="btn-cancel" data-modal-hide="popup-modal" type="button" class="btn-cancel" onclick="closeDelete({{ $element->dni }})">No, cancelar</button>
                            </div>
                        </div>
                    </div>
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
                            <button type="button" id="editar-{{ $element->dni }}" onclick="openEditModal({{ $element->dni }})"><i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            <button type="button" id="eliminar" onclick="openDeleteModal({{ $element->dni }})"><i class="fa-solid fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // $(document).ready(function () {
        //     $('#dataTable').DataTable({
        //         searching: true,
        //         paging: true
        //     });
        // });

        // function searchTable() {
        //     var input, filter, table, tr, td, i, txtValue;
        //     input = document.getElementById("searchInput");
        //     filter = input.value.toUpperCase();
        //     table = document.getElementById("dataTable");
        //     tr = table.getElementsByTagName("tr");
        //     for (i = 1; i < tr.length; i++) { // Empezar desde 1 para omitir la fila de encabezados
        //         var found = false;
        //         td = tr[i].getElementsByTagName("td");
        //         for (var j = 0; j < td.length - 1; j++) { // Iterar hasta td.length - 1 para excluir la columna de acciones
        //             txtValue = td[j].textContent || td[j].innerText;
        //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //                 found = true;
        //                 break;
        //             }
        //         }
        //         if (found) {
        //             tr[i].style.display = "";
        //         } else {
        //             tr[i].style.display = "none";
        //         }
        //     }
        // }

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

        var savedImage = sessionStorage.getItem("selectedImage");
        if (savedImage) {
            mainImage.src = savedImage;
        }

        // Abrir el modal al hacer clic en el botón
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // Cerrar el modal al hacer clic en la "x"
        span.onclick = function () {
            modal.style.display = "none";
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

        openEditModal = (dni) => {
            var editModal = document.getElementById("edit-modal-" + dni);
            editModal.style.display = "block";
        }

        closeEdit = (dni) => {
            var editModal = document.getElementById("edit-modal-" + dni);
            editModal.style.display = "none";
        }

        openDeleteModal = dni => {
            var deleteModal = document.getElementById("popup-modal-" + dni);
            deleteModal.style.display = "block";
        }

        closeDelete = dni => {
            var deleteModal = document.getElementById("popup-modal-" + dni);
            deleteModal.style.display = "none";
        }
    });
</script>

</html>