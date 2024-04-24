<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambio de Contraseña</title>
  <link rel="icon" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('css/ingresodato.css') }}">
</head>
<body>

  <div id="login-container">
    <h2>UNIDAD DE DOSAJE ETÍLICO</h2>
    
    <div id="content-container">
      <div class="Izquierda">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-image">
      </div>
      
      <div id="login-form" autocomplete="off">
        <form method="post"  action="">
          @csrf
            <div class="form-group">
                <label for="username">
                  <i class="fa-solid fa-envelope"></i>Email
                </label>
                <input type="email" id="username" name="username" required>
              </div>

              <div class="form-group">
                <label for="telefono">
                    <i class="fa-solid fa-phone"></i> Teléfono
                </label>
                <input type="text" id="telefono" name="username" pattern="\d{9}" title="Ingresa 9 dígitos numéricos" required>
            </div>
            
            <script>
              function restrictToNumbersAndLength(inputElement, maxLength) {
                inputElement.addEventListener("input", function () {
                  let inputValue = inputElement.value.replace(/\D/g, '');
                  inputValue = inputValue.slice(0, maxLength);
                  inputElement.value = inputValue;
                });
              }
            
              document.addEventListener("DOMContentLoaded", function () {
                const telefonoInput = document.getElementById("telefono");
                restrictToNumbersAndLength(telefonoInput, 9);
              });
            </script>
            
          <button class="ingresar">ENVIAR</button>
        
        </form>
      </div>
    </div>
  </div>


</body>
</html>
