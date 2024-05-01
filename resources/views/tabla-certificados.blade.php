<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla certificados</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ asset('js/importante.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/busqueda.css') }}">
    
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
            <h4>Filtro de Información</h4>
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
        <div class="search-container">
            @csrf
            <div class="search-input-container">
                <input type="text" id="searchInput" onkeyup="searchTable()"
                    placeholder="Buscar por nombres, apellidos o códigos...">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <button id="btnexel"><a id="letras" href="{{ route('exportar') }}"><i id="exel"
                        class="fa-solid fa-file-excel"></i>Exportar</a></button>
        </div>

        <table id="dataTable">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="content1">
                @foreach ($elementos as $elemento)
                    <tr>
                        <td>{{ $elemento->dni }}</td>
                        <td>{{ $elemento->nombre }}</td>
                        <td>{{ $elemento->apellido_paterno }}</td>
                        <td>{{ $elemento->apellido_materno }}</td>
                        <td>
                            <div id="progress-bar-container">
                                <div class="progress-bar"></div>
                            </div>
                        </td>
                        <td class="btn-container">
                            <button id="editar" onclick="editEntry()"><a
                                    href="{{ route('procesamiento', ['dni' => $elemento->dni]) }}"><i
                                        class="fa-solid fa-pen-to-square"></i> Editar </a></button>
                            <button id="ver"><a href="#"><i class="fa-solid fa-eye"></i> Ver</a></button>
                            <button id="pdf">
                                <a href="{{ route('generarPdf', ['dni' => $elemento->dni]) }}" target="_blank"><i
                                        id="icopdf" class="fa-regular fa-file-pdf"></i> Generar PDF</a>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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

        function generatePDF() {
            console.log("Generar PDF");
        }
    </script>

    <input type="checkbox" id="btn-menu">
    <div class="container-menu">
        <div class="cont-menu">
            <nav>
                <div class="imagen-container">
                    <img src="{{ asset('storage/' . auth()->user()->imagen_perfil) }}" class="img" alt="Logo">

                    <h2>{{ Auth::user()->name }}</h2>
                    <h6>{{ $grado ? $grado->grado : '' }}</h6>
                </div>
                <br><br>

                <a href="{{ route('home') }}"> <i class="fa-solid fa-house"></i> Inicio</a>
                <a href="{{ route('principal') }}"><i class="fa-solid fa-user-plus"></i> Añadir Usuario</a>
                <a href="{{ route('extraccion') }}"><i class="fa-solid fa-vials"></i> Extracción</a>
                <a href="{{ route('tbl-certificados') }}"> <i class="fa-solid fa-table-list"></i> Certificados</a>
                <a href="{{ route('logout') }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </nav>

            <label for="btn-menu"><i class="fa-solid fa-list"></i></label>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        const camposCompletados = {{ session('campos_completados', 0) }};

        function calcularProgreso() {
            const camposTotales = 27; // Número total de campos en tu formulario

            $('.progress-bar').each(function() {
                const progreso = Math.round((camposCompletados / camposTotales) * 100);
                $(this).css('width', progreso + '%');
            });
        }

        calcularProgreso();
    });

    document.addEventListener("DOMContentLoaded", function() {
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
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Cerrar el modal al hacer clic en la "x"
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cerrar el modal al hacer clic fuera del contenido del modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Previsualizar la imagen seleccionada antes de guardarla
        var imageInput = document.getElementById("imageInput");
        var previewImage = document.getElementById("previewImage");
        imageInput.addEventListener("change", function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Enviar el formulario para guardar la imagen
        var form = document.getElementById("imageForm");
        form.onsubmit = function(event) {
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
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        }
    });
</script>

</html>
