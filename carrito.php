<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="css/carrito.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .factura-container {
          padding-left: 250px;
          padding-right: 250px;
        }

        .content-container{
        padding-top: 50px;
        padding-bottom: 50px;
      }
    </style> 
  <body>
  <!-- Modal -->
  <div class="modal" id="modalCompraExito" tabindex="-1" aria-labelledby="modalCompraExito" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">¡Éxito!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Se ha realizado la compra exitosamente.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-dark" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modalCompraError" tabindex="-1" aria-labelledby="modalCompraError" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Error</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Se ha producido un error al intentar registrar su comprar.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
  </div>

    <?php
    require('navbar.php');
    require('connDB.php');

    if (isset($_REQUEST['idUser'])) {
      $idUser = $_REQUEST['idUser'];
      $idMovie = $_REQUEST['idMovie'];
      $idSucursal = $_REQUEST['idSucursal'];

      $proced = "BEGIN SERVICIOS_VARIOS.INSERTAR_COMPRA('$idUser','$idMovie','$idSucursal'); END;";
      $result = oci_parse(conectaOracle(), $proced);

      if ($result) {
        oci_execute($result, OCI_NO_AUTO_COMMIT); 
        oci_commit(conectaOracle());

        imprimeFactura();
        echo '<script type="text/javascript"> $(document).ready(function() {modalCompraExito();});</script>';
    } else {
      imprimeFactura();
        echo '<script type="text/javascript"> $(document).ready(function() {modalCompraError();});</script>';
    }
  } else {
    imprimeFactura();
  }
    
    function imprimeFactura(){

      if (isset($_SESSION['id'])) {
        $idUsuario = $_SESSION['id'];
      } else {
        header("Location: login.php");
      }

      $idPelicula = $_GET["idPelicula"];

      $queryUsuario = "SELECT NOMBRE, APELLIDO_PATERNO, APELLIDO_MATERNO, CORREO, DIRECCION, TELEFONO FROM USUARIOS WHERE ID_USUARIO = '$idUsuario'";
      $usuario = oci_parse(conectaOracle(), $queryUsuario);
      oci_execute($usuario);
      $row_user = oci_fetch_assoc($usuario);

      if (!empty($row_user) ) {
        $name = $row_user['NOMBRE'];
        $apellido1 = $row_user['APELLIDO_PATERNO'];
        $apellido2 = $row_user['APELLIDO_MATERNO'];
        $email = $row_user['CORREO'];
        $address = $row_user['DIRECCION'];
        $phone = $row_user['TELEFONO'];
        $completeName = $apellido1 . ' ' . $apellido2;
      }

      $queryPelicula = "SELECT P.TITULO, P.SINOPSIS, P.DURACION, P.PRECIO, G.DESCRIPCION FROM PELICULAS P, GENEROS G WHERE 
      P.GENERO_ID = G.ID_GENERO AND ID_PELICULA = '$idPelicula'";
      $pelicula = oci_parse(conectaOracle(), $queryPelicula);
      oci_execute($pelicula);
      $row_movie = oci_fetch_assoc($pelicula);

      if (!empty($row_movie) ) {
        $title = $row_movie['TITULO'];
        $synopsis = $row_movie['SINOPSIS'];
        $duration = $row_movie['DURACION'];
        $cost = $row_movie['PRECIO'];
        $category = $row_movie['DESCRIPCION'];
      }

      echo "<div class=\"content-container\">
        <div class=\"text-center\">
        <h2 class=\"fw-light\">¡Confirma tu Compra!</h2>
        <p class=\"lead text-muted\">Verifica tus datos y finaliza la compra.</p>
        </div>
        </div>";

      echo "<div class=\"factura-container\">
      <div class=\"container\">
      <div class=\"row g-5\">
      <div class=\"col-md-5 col-lg-4 order-md-last\">
        <h4 class=\"d-flex justify-content-between align-items-center mb-3\">
          <span class=\"text-dark\">Pelicula</span>
          <span class=\"badge bg-warning rounded-pill\">1</span>
        </h4>
        <ul class=\"list-group mb-3\">
          <li class=\"list-group-item d-flex justify-content-between lh-sm\">
            <div>
              <h6 class=\"my-0\">$title</h6>
              <small class=\"text-muted\">$category | </small>
              <small class=\"text-muted\">$duration Mins</small>
            </div>
            <span class=\"text-muted\">$$cost</span>
          </li>
          <li class=\"list-group-item d-flex justify-content-between\">
            <span>Total (USD)</span>
            <strong>$$cost</strong>
          </li>
        </ul>

          <div class=\"input-group\">
            <p>
            <button type=\"button\" class=\"btn btn-dark w-100 btn-lg\" data-bs-toggle=\"collapse\" 
            data-bs-target=\"#collapseSynopsis\" aria-expanded=\"false\" aria-controls=\"collapseSynopsis\">Ver Sinopsis</button>
            </p>
            <div style=\"min-height: 120px;\">
              <div class=\"collapse collapse-horizontal\" id=\"collapseSynopsis\">
                <div class=\"card card-body\" style=\"width: 300px;\">
                  $synopsis  
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class=\"col-md-7 col-lg-8\">
        <h4 class=\"mb-3\">Factura</h4>
        <form class=\"needs-validation\" method=\"post\">
          <div class=\"row g-3\">
            <div class=\"col-sm-6\">
              <label for=\"name\" class=\"form-label\">Nombre</label>
              <input type=\"text\" class=\"form-control\" name=\"name\" placeholder=\"$name\" value=\"$name\" disabled>
            </div>

            <div class=\"col-sm-6\">
              <label for=\"apellidos\" class=\"form-label\">Apellidos</label>
              <input type=\"text\" class=\"form-control\" name=\"apellidos\" placeholder=\"$completeName\" value=\"$completeName\" disabled>
            </div>

            <div class=\"col-sm-6\">
              <label for=\"email\" class=\"form-label\">Correo</label>
              <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"$email\" value=\"$email\">
            </div>
            
            <div class=\"col-sm-6\">
              <label for=\"phone\" class=\"form-label\">Teléfono</label>
              <input type=\"text\" class=\"form-control\" name=\"phone\" placeholder=\"$phone\" value=\"$phone\">
            </div>

            <div class=\"col-12\">
              <label for=\"address\" class=\"form-label\">Dirección</label>
              <input type=\"text\" class=\"form-control\" name=\"address\" placeholder=\"$address\" value=\"$address\" >
            </div>

            <div class=\"col-md-5\">
              <label for=\"sucursal\" class=\"form-label\">Sucursal</label>
              <select class=\"form-select\" name=\"idSucursal\" required>
                <option selected>Elegir...</option>
                <option value=\"1\">Vasquez de Coronado</option>
                <option value=\"2\">Jaco</option>
                <option value=\"3\">San Ramon</option>
                <option value=\"4\">Tierra Blanca</option>
                <option value=\"5\">Moin</option>
                <option value=\"6\">Bagaces</option>
                <option value=\"7\">Santo Domingo</option>
                <option value=\"8\">Moravia</option>
                <option value=\"9\">La Union</option>
                <option value=\"10\">Curridabat</option>
              </select>
            </div>

            <input type=\"hidden\" class=\"form-control\" name=\"idUser\" value=\"$idUsuario\" >
            <input type=\"hidden\" class=\"form-control\" name=\"idMovie\" value=\"$idPelicula\" >

          <hr class=\"my-4\">

          <h4 class=\"mb-3\">Información de Pago</h4>

          <div class=\"row gy-3\">
            <div class=\"col-md-6\">
              <label for=\"cc-name\" class=\"form-label\">Nombre en la Tajeta</label>
              <input type=\"text\" class=\"form-control\" id=\"cc-name\" placeholder=\"\" required>
              <small class=\"text-muted\">Nombre Mostrado en la Tarjeta</small>
            </div>

            <div class=\"col-md-6\">
              <label for=\"cc-number\" class=\"form-label\">Número de la Tarjeta</label>
              <input type=\"text\" class=\"form-control\" id=\"cc-number\" placeholder=\"\" required>
            </div>

            <div class=\"col-md-3\">
              <label for=\"cc-expiration\" class=\"form-label\">Vencimiento</label>
              <input type=\"text\" class=\"form-control\" id=\"cc-expiration\" placeholder=\"\" required>
            </div>

            <div class=\"col-md-3\">
              <label for=\"cc-cvv\" class=\"form-label\">CVV</label>
              <input type=\"text\" class=\"form-control\" id=\"cc-cvv\" placeholder=\"\" required>
            </div>
          </div>

          <hr class\"my-4\">

          <button class=\"w-100 btn btn-dark btn-lg\" type=\"submit\">Confirmar Compra</button>
        </form>
      </div>
    </div>
  </main>
  </div>
  </div>";
}
    
        require('footer.php');
        ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script language='JavaScript' type='text/javascript' src='js/mensajes.js'></script>
</body>
</html>