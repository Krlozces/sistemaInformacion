<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js/importante.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/principal.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    
    <div class="informacion">
        <div>
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
    
            <div class="boton3" id="segunMotivosBtn">
                SEGUN MOTIVOS
                <a href="#">
                    <i class="fa-regular fa-calendar"></i>
                </a>
            </div>
    
            <div class="boton4" id="segunResultadosBtn">
                SEGUN MUESTRAS
                <a href="#">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                </a>
            </div>
        </div>
    
        <div class="container4">
            <div class="boton5" id="segunEdadBtn">
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
    
    <div style="width: 80%; margin: auto;">
        <canvas id="myChart"></canvas>
    </div>  
    <!--	--------------->
    <input type="checkbox" id="btn-menu">
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

            var chartData = {!! $chartDataJson !!};

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Cantidad de muestras positivas',
                        data: chartData.values,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            },
                            display: true
                        },
                        y: {
                            beginAtZero: true,
                            display: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw;
                                }
                            }
                        }
                    }
                }
            });

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $('#segunMotivosBtn').click(function(){
                $.ajax({
                    url: '{{ route("segun-motivos") }}',
                    method: 'POST',
                    success: function(data) {
                        updateChart(data.type, data.motivosLabels, data.motivosValues);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener datos:', error);
                    }
                });
            });

            $('#segunEdadBtn').click(function(){
                $.ajax({
                    url: '{{ route("segun-edad") }}',
                    method: 'POST',
                    success: function(data) {
                        updateChart(data.type, data.yearLabels, data.yearValues);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener datos:', error);
                    }
                });
            });

            $('#segunResultadosBtn').click(function(){
                $.ajax({
                    url: '{{ route("segun-resultados") }}',
                    method: 'POST',
                    success: function(data) {
                        updateChart(data.type, data.resultsLabels, data.resultsValues);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener datos:', error);
                    }
                });
            });

            function updateChart(type, labels, values) {
                if (myChart) {
                    myChart.destroy();
                }

                let chartConfig = {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: type === 'pie' || type === 'doughnut' ? '' : 'Datos',
                            data: values,
                            borderColor: type === 'pie' || type === 'doughnut' ? [] : 'rgba(75, 192, 192, 1)',
                            borderWidth: type === 'pie' || type === 'doughnut' ? 1 : 2,
                            backgroundColor: type === 'pie' || type === 'doughnut' ? getPieColors(values.length) : 'rgba(75, 192, 192, 0.2)',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Gráfico ' + type.charAt(0).toUpperCase() + type.slice(1)
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.raw;
                                    }
                                }
                            }
                        }
                    }
                };

                if (type !== 'pie' && type !== 'doughnut') {
                    chartConfig.options.scales = {
                        x: {
                            beginAtZero: true,
                            display: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        },
                        y: {
                            beginAtZero: true,
                            display: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    };
                }

                myChart = new Chart(ctx, chartConfig);
            }

            function getPieColors(numColors) {
                const colors = [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ];
                const borderColor = [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ];
                let pieColors = [];
                for (let i = 0; i < numColors; i++) {
                    pieColors.push(colors[i % colors.length]);
                }
                return pieColors;
            }

        });
    </script>
</body>
</html>