<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
      .perfil-container{
        padding-top: 50px;
        padding-bottom: 50px;
      }

      .table-container{
        padding-top: 50px;
        padding-left: 300px;
        padding-right: 300px;
      }
    </style>
  </head>

<body>
  <?php
  require('navbar.php');
  require('connDB.php');
  ?>

  <!-- Modal -->
  <div class="modal modal-xl" id="modalUsuarioInfo" tabindex="-1" aria-labelledby="modalUsuarioInfo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Estado del Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    require('resumenCliente.php');
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

  <div class="perfil-container">
    <div class="text-center">
      <h2 class="fw-light">Bienvienido Administrador</h2>
      <p class="lead text-muted">Desde aquí puedes consultar diferentes reportes que te mostrarán información sobre el estado de la videoteca, haz click en cada categoría para ver 
          más información.
      </p>
    </div>
  </div>

  <div class="tabs">
    <div class="single-tabs tabs-one">
      <ul class="nav nav-justified" id="myTab" role="tablist">
          <li class="nav-item">
              <a class="active btn btn-dark btn-lg" type="button" id="tab-one-one-tab" data-bs-toggle="tab" href="#tab-one-one" role="tab"
                aria-controls="tab-one-one" style="--bs-btn-padding-x: 90px;" aria-selected="true">Clientes</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-dark btn-lg" type="button" id="tab-one-two-tab" data-bs-toggle="tab" href="#tab-one-two" role="tab"
                aria-controls="tab-one-two" style="--bs-btn-padding-x: 45px;" aria-selected="false">Inventario de Películas</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-dark btn-lg" type="button" id="tab-one-three-tab" data-bs-toggle="tab" href="#tab-one-three" role="tab"
                aria-controls="tab-one-three" style="--bs-btn-padding-x: 90px;" aria-selected="false">Sucursales</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-dark btn-lg" type="button" id="tab-one-four-tab" data-bs-toggle="tab" href="#tab-one-four" role="tab"
                aria-controls="tab-one-four" style="--bs-btn-padding-x: 90px;" aria-selected="false">Proveedores</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-dark btn-lg" type="button" id="tab-one-five-tab" data-bs-toggle="tab" href="#tab-one-five" role="tab"
                aria-controls="tab-one-five" style="--bs-btn-padding-x: 45px;" aria-selected="false">Reportes y Auditorias</a>
          </li>
      </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="tab-one-one" role="tabpanel" aria-labelledby="tab-one-one-tab">
          <?php
              muestraClientes();
              ?>
          </div>
          <div class="tab-pane fade" id="tab-one-two" role="tabpanel" aria-labelledby="tab-one-two-tab">
            <?php
              muestraPeliculas();
              ?>
          </div>
          <div class="tab-pane fade" id="tab-one-three" role="tabpanel" aria-labelledby="tab-one-three-tab">
              <?php
              muestraSucursales();
              ?>
          </div>
          <div class="tab-pane fade" id="tab-one-four" role="tabpanel" aria-labelledby="tab-one-four-tab">
            <?php
              muestraProveedores();
              ?>
          </div>
          <div class="tab-pane fade" id="tab-one-five" role="tabpanel" aria-labelledby="tab-one-five-tab">
              <?php
              muestraReportes();
              ?>
          </div>
        </div>
    </div>
    <!-- tabs one -->
  </div>

  <?php
  $idUsuario = null;

  function muestraClientes(){
    $usuariosCount = "SELECT COUNT(*) FROM USUARIOS";
    $stmt = oci_parse(conectaOracle(), $usuariosCount);
    oci_execute($stmt);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

    $usuarioQuery = "SELECT * FROM LISTA_USUARIOS";
    $stmt2 = oci_parse(conectaOracle(), $usuarioQuery);
    oci_execute($stmt2);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table table-dark table-sm caption-top table-hover\">";
    echo "<caption><h6>Lista de Clientes</h6></caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Nombre Completo</th>";
    echo "<th scope=\"col\">Correo</th>";
    echo "<th scope=\"col\">Teléfono</th>";
    echo "<th scope=\"col\">Dirección</th>";
    echo "<th scope=\"col\">Mas información</th>";
    echo "</tr>";
    echo "</thead>";

    if($numrows >= 1){
      echo "<tbody class=\"table-group-divider\">";
      
      while ($row = oci_fetch_assoc($stmt2)){
        $nombre =   $row["NOMBRE"];
        $apellido1 =   $row["APELLIDO_PATERNO"];
        $apellido2 =   $row["APELLIDO_MATERNO"];
        $nombreCompleto = $nombre . ' ' . $apellido1 . ' ' . $apellido2;
        $correo = $row["CORREO"];
        $telefono = $row["TELEFONO"];
        $direccion = $row["DIRECCION"];
  
        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/
        echo "<td>" . $nombreCompleto . "</td>"; 
        echo "<td>" . $correo . "</td>";
        echo "<td>" . $telefono . "</td>";
        echo "<td>" . $direccion . "</td>";
        echo "<td>" . "<a class=\"btn btn-warning right\" href='resumenCliente.php?idUser=" . $row["ID_USUARIO"] . "' data-bs-toggle=\"modal\" 
        data-bs-target=\"#modalUsuarioInfo\">Ver Más</a>" .   "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no existen clientes</th>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  }

  /*function muestraEstado(){

    $id = $GET_['id'];

    /*$usuarioCount = "SELECT COUNT(*) FROM USUARIOS WHERE ID_USUARIO = '$id'";
    $stmt2 = oci_parse(conectaOracle(), $usuarioCount);
    oci_execute($stmt2);
    */

    /*$funCount = "SELECT VALIDA_USUARIO('$id') FROM DUAL";
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

    /*$funcPerfil = "SELECT CONSULTA_PERFIL_USUARIO('$id') AS PERFIL FROM DUAL";
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
        /*echo "<td>" . $pelicula . "</td>";
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
}*/

  function muestraPeliculas(){
    $peliculasCount = "SELECT COUNT(*) FROM PELICULAS";
    $stmt3 = oci_parse(conectaOracle(), $peliculasCount);
    oci_execute($stmt3);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt3, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

    $peliculasQuery = "SELECT * FROM LISTA_PELICULAS";
    $stmt4 = oci_parse(conectaOracle(), $peliculasQuery);
    oci_execute($stmt4);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table table-dark table-sm caption-top table-hover\">";
    echo "<caption><h6>Inventario de Películas</h6></caption>";
    echo "<caption><a class=\"btn btn-warning\" type=\"button\" href=\"insertaPelicula.php\">Ingresar Nueva Película</a></caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Título</th>";
    echo "<th scope=\"col\">Género</th>";
    echo "<th scope=\"col\">Director</th>";
    echo "<th scope=\"col\">Protagonista</th>";
    echo "<th scope=\"col\">Fecha de Estreno</th>";
    echo "<th scope=\"col\">Duración</th>";
    echo "<th scope=\"col\">Precio</th>";
    echo "</tr>";
    echo "</thead>";

    if($numrows >= 1){
      echo "<tbody class=\"table-group-divider\">";
      
      while ($row = oci_fetch_assoc($stmt4)){
        $titulo =   $row["TITULO"];
        $genero =   $row["GENERO_ID"];
        $director =   $row["DIRECTOR"];
        $protagonista = $row["PROTAGONISTA"];
        $fecha_estreno = $row["FECHA_ESTRENO"];
        $duracion = $row["DURACION"];
        $precio = $row["PRECIO"];

        $categoria = 0;

        if($genero == 1){
          $categoria = 'Comedia';
        } else if ($genero == 2){
          $categoria = 'Aventura';
        } else if ($genero == 3){
          $categoria = 'Drama';
        } else if ($genero == 4){
          $categoria = 'Acción';
        } else if ($genero == 5){
          $categoria = 'Musical';
        } else if ($genero == 6){
          $categoria = 'Documental';
        } else if ($genero == 7){
          $categoria = 'Horror';
        } else if ($genero == 8){
          $categoria = 'Romántico';
        } else if ($genero == 9){
          $categoria = 'SCI-FIC';
        } else if ($genero == 10){
          $categoria = 'Crimen';
        }
        
        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/
        echo "<td>" . $titulo . "</td>"; 
        echo "<td>" . $categoria . "</td>";
        echo "<td>" . $director . "</td>";
        echo "<td>" . $protagonista . "</td>";
        echo "<td>" . $fecha_estreno . "</td>"; 
        echo "<td>" . $duracion . ' ' . "MIN </td>";
        echo "<td> $" . $precio . "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no existen clientes</th>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  }

  function muestraSucursales(){
    $sucursalCount = "SELECT COUNT(*) FROM SUCURSALES";
    $stmt2 = oci_parse(conectaOracle(), $sucursalCount);
    oci_execute($stmt2);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt2, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

    $sucursalQuery = "SELECT * FROM LISTA_SUCURSALES";
    $stmt = oci_parse(conectaOracle(), $sucursalQuery);
    oci_execute($stmt);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table table-dark table-sm caption-top table-hover\">";
    echo "<caption><h6>Lista de Sucursales</h6></caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Provincia</th>";
    echo "<th scope=\"col\">Cantón</th>";
    echo "<th scope=\"col\">Dirección</th>";
    echo "</tr>";
    echo "</thead>";

    if($numrows >= 1){
      echo "<tbody class=\"table-group-divider\">";
      
      while ($row = oci_fetch_assoc($stmt)){
        $provincia =   $row["PROVINCIA"];
        $canton = $row["CANTON"];
        $direccion = $row["DIRECCION"];
  
        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/
        echo "<td>" . $provincia . "</td>"; 
        echo "<td>" . $canton . "</td>";
        echo "<td>" . $direccion . "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no has comprado ninguna película</th>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  }

  function muestraProveedores(){
    $proveedoresCount = "SELECT COUNT(*) FROM PROVEEDORES";
    $stmt5 = oci_parse(conectaOracle(), $proveedoresCount);
    oci_execute($stmt5);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt5, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

    $proveedoresQuery = "SELECT * FROM PROVEEDORES";
    $stmt6 = oci_parse(conectaOracle(), $proveedoresQuery);
    oci_execute($stmt6);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table table-dark table-sm caption-top table-hover\">";
    echo "<caption><h6>Lista de Proveedores</h6></caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Nombre</th>";
    echo "<th scope=\"col\">Contacto</th>";
    echo "<th scope=\"col\">Correo</th>";
    echo "<th scope=\"col\">Teléfono</th>";
    echo "<th scope=\"col\">Dirección</th>";
    echo "</tr>";
    echo "</thead>";

    if($numrows >= 1){
      echo "<tbody class=\"table-group-divider\">";
      
      while ($row = oci_fetch_assoc($stmt6)){
        $nombre =   $row["NOMBRE"];
        $contacto =   $row["CONTACTO"];
        $correo = $row["CORREO"];
        $telefono = $row["TELEFONO"];
        $direccion = $row["DIRECCION"];
  
        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/
        echo "<td>" . $nombre . "</td>"; 
        echo "<td>" . $contacto . "</td>"; 
        echo "<td>" . $correo . "</td>";
        echo "<td>" . $telefono . "</td>";
        echo "<td>" . $direccion . "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no existen clientes</th>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  }

  function muestraReportes(){
    $reportesCount = "SELECT COUNT(*) FROM AUDITORIA_ERRORES";
    $stmt6 = oci_parse(conectaOracle(), $reportesCount);
    oci_execute($stmt6);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt6, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

    $auditCount = "SELECT COUNT(*) FROM AUDITORIA_MODIFICACIONES";
    $stmt8 = oci_parse(conectaOracle(), $auditCount);
    oci_execute($stmt8);

    $numrows_audit = null;

    while (($rows_audit = oci_fetch_array($stmt8, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows_audit as $numrows_audit) {
        }
    }

    $erroresQuery = "SELECT * FROM LISTA_ERRORES";
    $stmt7 = oci_parse(conectaOracle(), $erroresQuery);
    oci_execute($stmt7);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table table-dark table-sm caption-top table-hover\">";
    echo "<caption><h6>Lista de Errores Registrados</h6></caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Usuario</th>";
    echo "<th scope=\"col\">Movimiento</th>";
    echo "<th scope=\"col\">Mensaje</th>";
    echo "<th scope=\"col\">Código</th>";
    echo "<th scope=\"col\">Fecha de Movimiento</th>";
    echo "</tr>";
    echo "</thead>";

    if($numrows >= 1){
      echo "<tbody class=\"table-group-divider\">";
      
      while ($row = oci_fetch_assoc($stmt7)){
        $date =   $row["FECHA"];
        $source =   $row["ORIGEN"];
        $code = $row["CODIGO_ERROR"];
        $message = $row["MENSAJE_ERROR"];
        $user = $row["USUARIO"];
  
        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/
        echo "<td>" . $user . "</td>"; 
        echo "<td>" . $source . "</td>"; 
        echo "<td>" . $message . "</td>";
        echo "<td>" . $code . "</td>";
        echo "<td>" . $date . "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no existen clientes</th>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    $cambiosQuery = "SELECT * FROM LISTA_CAMBIOS";
    $stmt9 = oci_parse(conectaOracle(), $cambiosQuery);
    oci_execute($stmt9);

    echo "<div class=\"table-container\">";
    echo "<table class=\"table table-dark table-sm caption-top table-hover\">";
    echo "<caption><h6>Lista de Cambios Registrados</h6></caption>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope=\"col\">Usuario</th>";
    echo "<th scope=\"col\">Fuente</th>";
    echo "<th scope=\"col\">Acción</th>";
    echo "<th scope=\"col\">Fecha</th>";
    echo "</tr>";
    echo "</thead>";

    if($numrows_audit >= 1){
      echo "<tbody class=\"table-group-divider\">";
      
      while ($row_audit = oci_fetch_assoc($stmt9)){
        $fecha =   $row_audit["FECHA"];
        $fuente =   $row_audit["DATO_MODIFICADO"];
        $action = $row_audit["ACCION"];
        $usuario = $row_audit["USUARIO"];
  
        echo "<tr>";
        /*echo "<th scope=\"row\"></th>";*/
        echo "<td>" . $usuario . "</td>"; 
        echo "<td>" . $fuente . "</td>"; 
        echo "<td>" . $action . "</td>";
        echo "<td>" . $fecha . "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr>";
      echo " <th>Aún no existen clientes</th>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  }
    require('footer.php');
    ?>
  </body>
</html>