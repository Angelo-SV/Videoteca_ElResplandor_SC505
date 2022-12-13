<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link type="text/css" rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/normalize.css">
  </head>

<body>
    <header class="p-3 text-bg-dark">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="index.php"><img src="img/logo-removebg-preview.png" width="90" height="40"></a></li> 
              <li><a href="index.php#1" class="nav-link px-2 text-white">Estrenos</a></li>
              <li><a href="nosotros.php" class="nav-link px-2 text-white">Nosotros</a></li>
            </ul>

              <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
              </form>

              <div class="text-end">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 mb-md-0">
                  <?php
                  if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                  } 
                  if (!isset($_SESSION['correo'])){
                    echo "<li><a href=\"login.php\" type=\"button\" class=\"btn btn-outline-light me-2\">Iniciar Sesión</a></li>";
                    echo "<li><a href=\"registro.php\" type=\"button\" class=\"btn btn-warning\">Registrarse</a></li>";
                  } else {
                    if ($_SESSION['rol'] == '1') {
                      echo "<li><a href=\"perfil_usuario.php\" type=\"button\" class=\"btn btn-outline-light me-2\">Mi Perfil</a></li>";
                    } else {
                      echo "<li><a href=\"admin_panel.php\" type=\"button\" class=\"btn btn-outline-light me-2\">ADMIN</a></li>";
                    }
                    echo "<li><a href=\"logout.php\"><input type=\"button\" class=\"btn btn-warning\" value=\"Cerrar Sesión\"></a></li>";
                  }
                  ?>
                </ul>
              </div>
            </ul>
          </div>
        </div>
      </header>
    </body>
</html>