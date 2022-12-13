<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      .perfil-container{
        padding-top: 50px;
      }

      .table-container{
        padding-left: 400px;
        padding-right: 400px;
      }
    </style> 
</head>

<body>
  <?php
  require('navbar.php');
  require('connDB.php');
  ?>

  <!-- Modal -->
  <div class="modal" id="modalUserExito" tabindex="-1" aria-labelledby="modalUserExito" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">¡Éxito!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Se han actualizado tus datos correctamente</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-dark" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modalUserError" tabindex="-1" aria-labelledby="modalUserError" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Error</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Se ha producido un error al actualizar tus datos</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
          </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modalUserContrasena" tabindex="-1" aria-labelledby="modalUserContrasena" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Error</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Se actualizó el usuario correctamente, la contraseña no ha sido modificada</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="perfil-container">
    <div class="text-center">
      <div class="bd-placeholder-img rounded-circle"> 
        <img src="img/user.png" width="140" height="140">
      </div>
      <h2 class="fw-light">¡Bienvenido a tu perfil!</h2>
      <p class="lead text-muted">Como usuario puedes administrar tu perfil visualizando tu datos personales, tus productos y modificando tu información.</p>
    </div>
  </div>

  <section class="py-3 text-center container">
    <div class="row py-lg-3">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h2 class="fw-light">Tu Estado</h2>
      </div>
    </div>
  </section>

  <?php
  function passwordHash($stringVar){
    $stringVar = stripslashes($stringVar);
    $stringVar = password_hash($stringVar, PASSWORD_BCRYPT);
    return $stringVar;
  }

  if (isset($_REQUEST['id'])) {

    $id = $_REQUEST['id'];
    $nombre = $_REQUEST['nombre'];
    $apellido1 = $_REQUEST['apellido1'];
    $apellido2 = $_REQUEST['apellido2'];
    $telefono = $_REQUEST['telefono'];
    $direccion = $_REQUEST['direccion'];
    $correo = $_REQUEST['correo'];
    $nuevaContrasena = $_REQUEST['newContrasena'];
    $viejaContrasena = $_REQUEST['oldContrasena'];

    /*$correoQuery = "SELECT COUNT(*) FROM USUARIOS WHERE ID_USUARIO ='$id'";
    $stmt = oci_parse(conectaOracle(), $correoQuery);
    oci_execute($stmt);*/

    $func = "SELECT SERVICIOS_VARIOS.VALIDA_USUARIO('$id') FROM DUAL";
    $stmt = oci_parse(conectaOracle(), $func);
    oci_execute($stmt);

    while (($row_num = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
      foreach ($row_num as $num_rows) {
      }
    }
    
    /*$usuarioQuery = "SELECT ID_USUARIO, CORREO, CONTRASENA FROM USUARIOS WHERE ID_USUARIO ='$id'";
    $usuario = oci_parse(conectaOracle(), $usuarioQuery);
    oci_execute($usuario);*/

    $func2 = "SELECT CONSULTA_CREDENCIALES('$id') AS CREDENCIALES FROM DUAL";
    $stmt2 = oci_parse(conectaOracle(), $func2);
    oci_execute($stmt2);

    $row_creden = oci_fetch_array($stmt2, OCI_ASSOC);
    $data2 = $row_creden['CREDENCIALES'];
    oci_execute($data2);

		if ($num_rows == 1) {
        /*$row_user = oci_fetch_assoc($usuario);*/
        $credencial_row = oci_fetch_array($data2, OCI_ASSOC);
		}  

    if (!empty(/*$row_user*/$credencial_row) ) {
      try {
        $password = $credencial_row['CONTRASENA'];
        $id = $credencial_row['ID_USUARIO'];

        $errorContrasena = 0;

        if (password_verify($viejaContrasena, $password) && !empty($viejaContrasena) && !empty($nuevaContrasena)) {
          $password = passwordHash($nuevaContrasena);
        } else if(!password_verify($viejaContrasena, $password)){
          $errorContrasena = 1;
        }

        /*$updatequery = "UPDATE USUARIOS SET NOMBRE = '$nombre', APELLIDO_PATERNO = '$apellido1', APELLIDO_MATERNO = '$apellido2', TELEFONO = '$telefono', DIRECCION = '$direccion', 
        CORREO = '$correo', CONTRASENA = '$password' WHERE ID_USUARIO = '$id'";
        $result = oci_parse(conectaOracle(), $updatequery);*/

        $proced = "BEGIN ACTUALIZAR_USUARIO('$nombre','$apellido1','$apellido2', '$correo', '$telefono', '$direccion ', '$password', '$id'); END;";
        $result = oci_parse(conectaOracle(), $proced);
        
        if ($result && $errorContrasena == 0) {
          oci_execute($result, OCI_NO_AUTO_COMMIT); 
          oci_commit(conectaOracle());

          muestraEstado();
          ImprimeDatos();
          echo '<script type="text/javascript"> $(document).ready(function() {modalUserExito();});</script>';
        } else if ($result && $errorContrasena == 1){
          oci_execute($result, OCI_NO_AUTO_COMMIT);
          oci_commit(conectaOracle());

          muestraEstado();
          ImprimeDatos();
          echo '<script type="text/javascript"> $(document).ready(function() {modalUserContrasena();});</script>';
        }
          } catch (Exception $e) {
            muestraEstado();
            ImprimeDatos();
            echo '<script type="text/javascript"> $(document).ready(function() {modalUserError();});</script>';
          }
    } else {
      muestraEstado();
      ImprimeDatos();
      echo '<script type="text/javascript"> $(document).ready(function() {modalUserError();});</script>';
    }
  } else {
    muestraEstado();
    ImprimeDatos();
  }

  function muestraEstado(){
    if (isset($_SESSION['id'])) {
      $id = $_SESSION['id'];
    } else {
      header("Location: index.php");
    }

    /*$usuarioCount = "SELECT COUNT(*) FROM USUARIOS WHERE ID_USUARIO = '$id'";
    $stmt2 = oci_parse(conectaOracle(), $usuarioCount);
    oci_execute($stmt2);*/

    $funCount = "SELECT SERVICIOS_VARIOS.VALIDA_USUARIO('$id') FROM DUAL";
    $stmt2 = oci_parse(conectaOracle(), $funCount);
    oci_execute($stmt2);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt2, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

    /*$consultaEstado = "SELECT U.MOROSIDAD, P.TITULO, P.PRECIO, S.CANTON FROM USUARIOS U, PELICULAS P, SUCURSALES S, ALQUILERES A WHERE U.ID_USUARIO = A.ID_USUARIO AND 
    P.ID_PELICULA = A.ID_PELICULA AND S.ID_SUCURSAL = A.ID_SUCURSAL AND U.ID_USUARIO ='$id'";
    $stmt3 = oci_parse(conectaOracle(), $consultaEstado);
    oci_execute($stmt3);*/

    $funcPerfil = "SELECT CONSULTA_PERFIL_USUARIO('$id') AS PERFIL FROM DUAL";
    $result2 = oci_parse(conectaOracle(), $funcPerfil);
    oci_execute($result2);

    $row = oci_fetch_array($result2, OCI_ASSOC);
    $data = $row['PERFIL'];
    oci_execute($data);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Mis Peliculas</th>";
    echo "<th scope=\"col\">Precio</th>";
    echo "<th scope=\"col\">Sucursal</th>";
    echo "<th scope=\"col\">Estado</th>";
    echo "</tr>";
    echo "</thead>";

    if ($numrows >= 1) {
      echo "<tbody>";
    
      while ($data_row = oci_fetch_array($data, OCI_ASSOC)){
        
        $moroso = $data_row["MOROSIDAD"];
        $pelicula = $data_row["TITULO"];
        $costo = $data_row["PRECIO"];
        $sucursal = $data_row["CANTON"];
        $pendientes = null;

        if($moroso == 1){
          $pendientes = "Alquiler Finalizado";
        } else if ($moroso == 2){
          $pendientes = "Alquiler Pendiente";
        }

        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/ 
        echo "<td>" . $pelicula . "</td>";
        echo "<td> $" . $costo . "</td>";
        echo "<td>" . $sucursal . "</td>"; 
        echo "<td>" . $pendientes . "</td>"; 
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no has comprado ninguna película</th>";
      echo "</tr>";
    }

    echo "</tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

  function ImprimeDatos(){
    echo "<section class=\"py-3 text-center container\">
            <div class=\"row py-lg-3\">
              <div class=\"col-lg-6 col-md-8 mx-auto\">
              <h2 class=\"fw-light\">Actualiza tus Datos</h2>
              </div>
            </div>
          </section>";

    if (isset($_SESSION['id'])) {
      $id = $_SESSION['id'];
    } else {
      header("Location: index.php");
    }

    /*$usuarioCount = "SELECT COUNT(*) FROM USUARIOS WHERE ID_USUARIO = '$id'";
    $stmt2 = oci_parse(conectaOracle(), $usuarioCount);
    oci_execute($stmt2);*/

    $funCount2 = "SELECT SERVICIOS_VARIOS.VALIDA_USUARIO('$id') FROM DUAL";
    $stmt3 = oci_parse(conectaOracle(), $funCount2);
    oci_execute($stmt3);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt3, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }
    
    /*$idQuery = "SELECT * FROM USUARIOS WHERE ID_USUARIO ='$id'";
    $idUsuario = oci_parse(conectaOracle(), $idQuery);
    oci_execute($idUsuario);*/

    $funcUser = "SELECT CONSULTA_USUARIO('$id') AS USUARIO FROM DUAL";
    $result3 = oci_parse(conectaOracle(), $funcUser);
    oci_execute($result3);

    $row = oci_fetch_array($result3, OCI_ASSOC);
    $data = $row['USUARIO'];
    oci_execute($data);

    if ($numrows == 1) {
      while ($data_row = oci_fetch_array($data, OCI_ASSOC)){
        $GLOBALS['id'] = $data_row["ID_USUARIO"];
        $nombre =   $data_row["NOMBRE"];
        $apellido1 =   $data_row["APELLIDO_PATERNO"];
        $apellido2 =   $data_row["APELLIDO_MATERNO"];
        $correo = $data_row["CORREO"];
        $telefono = $data_row["TELEFONO"];
        $direccion = $data_row["DIRECCION"];

        echo "<div class=\"form-container\">
                <form class=\"row g-3\" name=\"updateuser\" id=\"updateuser\" method=\"post\">
                  <div class=\"col-md-4\">
                    <label for=\"nombre\" class=\"form-label\">Nombre</label>
                    <input type=\"text\" name=\"nombre\" class=\"form-control\" value=\"$nombre\" placeholder=\"$nombre\">
                  </div>
                  <div class=\"col-md-4\">
                    <label for=\"apellido1\" class=\"form-label\">Primer Apellido</label>
                    <input type=\"text\" name=\"apellido1\" class=\"form-control\" value=\"$apellido1\" placeholder=\"$apellido1\">
                  </div>
                  <div class=\"col-md-4\">
                    <label for=\"apellido2\" class=\"form-label\">Segundo Apellido</label>
                    <input type=\"text\" name=\"apellido2\" class=\"form-control\" value=\"$apellido2\" placeholder=\"$apellido2\">
                  </div>
                  <div class=\"col-md-4\">
                    <label for=\"telefono\" class=\"form-label\">Telefono</label>
                    <input type=\"tel\" name=\"telefono\" class=\"form-control\" value=\"$telefono\" placeholder=\"$telefono\">
                  </div>
                  <div class=\"col-md-8\">
                    <label for=\"direccion\" class=\"form-label\">Dirección</label>
                    <input type=\"text\" name=\"direccion\" class=\"form-control\" value=\"$direccion\" placeholder=\"$direccion\">
                  </div>
                  <div class=\"col-md-4\">
                    <label for=\"correo\" class=\"form-label\">Correo</label>
                    <input type=\"email\" name=\"correo\" class=\"form-control\" value=\"$correo\" placeholder=\"$correo\">
                  </div>
                  <div class=\"col-md-4\">
                    <label for=\"contrasenaVieja\" class=\"form-label\">Contraseña Anterior</label>
                    <input type=\"password\" name=\"oldContrasena\" class=\"form-control\" >
                  </div>
                  <div class=\"col-md-4\">
                    <label for=\"contrasenaNueva\" class=\"form-label\">Contraseña Nueva</label>
                    <input type=\"password\" name=\"newContrasena\" class=\"form-control\">
                  </div>
                  <input type=\"hidden\" name=\"id\" class=\"form-control\" value=\"$id\">
                  <div class=\"col-12\">
                    <button type=\"submit\" name=\"btnsubmit\" id=\"btnsubmit\" class=\"btn btn-dark\">Actualizar mis Datos</button>
                  </div>
                </form>
              </div>";
      }
    }
  }
  require('footer.php');
  ?>
  <script language='JavaScript' type='text/javascript' src='js/mensajes.js'></script>
  </body>
</html>