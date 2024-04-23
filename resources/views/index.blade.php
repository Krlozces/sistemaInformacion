<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
  <link rel="icon" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="{{asset('js/importante.js')}}"></script>
</head>
<body>
  <div id="login-container">
    <h2>UNIDAD DE DOSAJE ETÍLICO</h2>
    
    <div id="content-container">
      <div class="Izquierda">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-image">
      </div>
      
      <div id="login-form" autocomplete="off">
        <form method="post" action="{{ route('signin') }}">
          @csrf
          <div class="form-group">
            <label for="email">
              <i class="fa-solid fa-envelope"></i> Email
            </label>
            <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group password-group">
            <label for="password">
              <i class="fas fa-lock"></i> Password</label>
              <div  class="password-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye-slash" id="show-password" onclick="togglePasswordVisibility()"></i> <!-- Icono de ojo para mostrar/ocultar contraseña -->
              </div>


          <a class="olvidar" href="{{ route('ingresar-datos') }}">¿Olvidaste la contraseña?</a>

          <button class="ingresar" type="submit">INGRESAR </button>

          <a class="registro" href="{{ route('registrarte') }}">Registrarte</a>
        </form>
      </div>
    </div>
  </div>

  <script>
    // JavaScript para mostrar/ocultar la contraseña
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById("password");
      const showPasswordIcon = document.getElementById("show-password");
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Cambiar el ícono del ojo
      const eyeIconClass = type === "password" ? "fa-eye-slash" : "fa-eye";
      showPasswordIcon.classList.remove("fa-eye-slash", "fa-eye");
      showPasswordIcon.classList.add(eyeIconClass);
    }
  </script>
</body>
</html>
