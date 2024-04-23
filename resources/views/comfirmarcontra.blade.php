<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambio de Contraseña</title>
  <link rel="stylesheet" href="{{ asset('css/cambiocontra.css') }}">
  <link rel="icon" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div id="login-container">
    <h2>UNIDAD DE DOSAJE ETÍLICO</h2>
    
    <div id="content-container">
      <div class="Izquierda">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-image">
      </div>
      
      <div id="login-form" autocomplete="off">
        <form method="post" action="">
          @csrf
              <div class="form-group password-group">
                <label for="password">
                  <i class="fas fa-lock"></i>Contraseña</label>
                  <input type="password" id="password" name="password" required>
                  <i class="fas fa-eye-slash" id="show-password" onclick="togglePasswordVisibility()"></i> <!-- Icono de ojo para mostrar/ocultar contraseña -->
                
              </div>

              <div class="form-group password-group">
                <label for="password1">
                  <i class="fas fa-lock"></i> Nueva Contraseña</label>
                  <input type="password" id="password1" name="password1" required>
                  <i class="fas fa-eye-slash" id="show-password1" onclick="togglePasswordVisibility1()"></i> <!-- Icono de ojo para mostrar/ocultar contraseña -->
            </div>
            <script>
                // JavaScript para mostrar/ocultar la contraseña
                function togglePasswordVisibility1() {
                  const passwordInput = document.getElementById("password1");
                  const showPasswordIcon = document.getElementById("show-password1");
                  const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
                  passwordInput.setAttribute("type", type);
              
                  // Cambiar el ícono del ojo
                  const eyeIconClass = type === "password" ? "fa-eye-slash" : "fa-eye";
                  showPasswordIcon.classList.remove("fa-eye-slash", "fa-eye");
                  showPasswordIcon.classList.add(eyeIconClass);
                }
              </script>
              

          <button class="ingresar">ACTUALIZAR</button>
        
          <a href="index.html">Iniciar Sesión</a>
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
