<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link type="text/css" rel="stylesheet" href="css/registro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .form-container{
            padding-left: 400px;
            padding-right: 400px;
            padding-bottom: 50px;
        }

        .peliculas-container{
        padding-top: 50px;
        padding-bottom: 50px;
      }
    </style> 
</head>

<body>
    <!-- Modal -->
    <div class="modal" id="modalPeliculaError" tabindex="-1" aria-labelledby="mmodalPeliculaError" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error al Ingresar la Película</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ha ocurrido un error al intentar ingresar la película.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalPeliculaExito" tabindex="-1" aria-labelledby="modalPeliculaExito" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¡Registro de Película Exitoso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¡La película se ha ingresado en inventario exitosamente!</p>
                </div>
                <div class="modal-footer">
                    <a href="login.php"><input type="button" class="btn btn-dark" data-bs-dismiss="modal" value="Iniciar Sesión"></a>
                </div>
            </div>
        </div>
    </div>

    <?php
    require('navbar.php');
    require('connDB.php');

    echo "<div class=\"peliculas-container\">
    <div class=\"text-center\">
    <div class=\"bd-placeholder-img rounded-circle\"> 
        <img src=\"img/logo-removebg-preview.png\" width=\"140\" height=\"140\">
    </div>
    <h2 class=\"fw-light\">Inventario de Películas</h2>
    <p class=\"lead text-muted\">LLena todos los campos para registrar una nueva película en inventario.</p>
    </div>
    </div>";

    if (isset($_REQUEST['titulo'])){
        $title = $_REQUEST['titulo'];
        $protagonist = $_REQUEST['protagonista'];
        $direct = $_REQUEST['director'];
        $premiere = $_REQUEST['estreno'];
        $duration = $_REQUEST['duracion'];
        $cost = $_REQUEST['precio'];
        $category = $_REQUEST['genero'];
        $studio = $_REQUEST['estudio'];
        $supplier = $_REQUEST['proveedor'];
        $synopsis = $_REQUEST['sinopsis'];

        $titleOk       = false;
        $protagonistOk = false;
        $directOk      = false;
        $premiereOk    = false;
        $durationOk    = false;
        $costOk        = false;
        $categoryOk    = false;
        $studioOk      = false;
        $supplierOk    = false;
        $synopsisOk    = false;
              
        if ($title == "") {
            print "  <p class=\"aviso\">No ha ingresado el título.</p>\n";
            print "\n";
        } else {
            $titleOk = true;
        }

        if ($protagonist == "") {
            print "  <p class=\"aviso\">No ha ingresado el protagonista.</p>\n";
            print "\n";
        } else {
            $protagonistOk = true;
        }

        if ($direct == "") {
            print "  <p class=\"aviso\">No ha ingresado al director.</p>\n";
            print "\n";
        } else {
            $directOk = true;
        }

        if ($duration == "") {
            print "  <p class=\"aviso\">No ha ingresado la duración en horas.</p>\n";
            print "\n";
        } else {
            $durationOk = true;
        }
    
        if ($cost == "") {
            print "  <p class=\"aviso\">No ha ingresado el costo.</p>\n";
            print "\n";
        } else {
            $costOk = true;
        }

        if ($synopsis == "") {
            print "  <p class=\"aviso\">No ha ingresado la sinopsis de la película.</p>\n";
            print "\n";
        } else {
            $synopsisOk = true;
        }

        if ($premiere == "") {
            print "  <p class=\"aviso\">No ha ingresado la fecha de estreno de la película.</p>\n";
            print "\n";
        } else {
            $premiereOk = true;
        }

        if ($category == "") {
            print "  <p class=\"aviso\">No ha seleccionado la categoría.</p>\n";
            print "\n";
          } elseif (!is_numeric($category)) {
            print "  <p class=\"aviso\">La categoría no es válida.</p>\n";
            print "\n";
          }elseif ($category < 1 || $category > 10) {
            print "  <p class=\"aviso\">La categoaría es incorrecta.</p>\n";
            print "\n";
          } else {
            $categoryOk = true;
          }

        if ($studio == "") {
            print "  <p class=\"aviso\">No ha seleccionado el estudio.</p>\n";
            print "\n";
          } elseif (!is_numeric($studio)) {
            print "  <p class=\"aviso\">El estudio no es válido.</p>\n";
            print "\n";
          }elseif ($studio < 1 || $studio > 10) {
            print "  <p class=\"aviso\">El estudio es incorrecto.</p>\n";
            print "\n";
          } else {
            $studioOk = true;
          }

        if ($supplier == "") {
            print "  <p class=\"aviso\">No ha seleccionado el proveedor.</p>\n";
            print "\n";
          } elseif (!is_numeric($supplier)) {
            print "  <p class=\"aviso\">El proveedor no es válido.</p>\n";
            print "\n";
          }elseif ($supplier < 1 || $supplier > 10) {
            print "  <p class=\"aviso\">El proveedor es incorrecto.</p>\n";
            print "\n";
          } else {
            $supplierOk = true;
          }

        if($titleOk && $protagonistOk && $directOk && $durationOk && $costOk && $synopsisOk && $categoryOk && $studioOk && $supplierOk &&
         $premiereOk){
            /*$correoQuery = "SELECT COUNT(CORREO) FROM USUARIOS WHERE CORREO ='$correo'";*/

            $func = "SELECT SERVICIOS_VARIOS.VALIDA_PELICULA('$title') FROM DUAL";
            $stmt = oci_parse(conectaOracle(), $func);
            oci_execute($stmt);

            $numrows = null;

            while (($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
                foreach ($row as $numrows) {
                    /*print "  <p>$numrows</p>";*/
                }
            }

            if ($numrows == 0){
                
                $proced = "BEGIN INSERTAR_PELICULA('$title', '$synopsis ', '$category', '$protagonist', '$direct', '$studio', '$premiere',
                '$duration', '$cost', '$supplier'); END;";
                $result = oci_parse(conectaOracle(), $proced);

                if($result){
                    oci_execute($result, OCI_NO_AUTO_COMMIT); 
                    oci_commit(conectaOracle());

                    formW();
                    echo '<script type="text/javascript"> $(document).ready(function() {modalPeliculaExito();});</script>';
                } 
            } else {
                formW();
                echo '<script type="text/javascript"> $(document).ready(function() {modalPeliculaError();});</script>';
            }
        }
    } else {
        formW();
    }

    function formW(){
        ?>
        <div class="form-container">
            <form class="row g-3" name="insertmovie" id="insertmovie" method="post">
                <div class="col-md-4">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" placeholder="Título">
                </div>
                <div class="col-md-4">
                <label for="protagonista" class="form-label">Protagonizada por</label>
                <input type="text" name="protagonista" class="form-control" placeholder="Protagonista">
                </div>
                <div class="col-md-4">
                <label for="director" class="form-label">Director</label>
                <input type="text" name="director" class="form-control" placeholder="director">
                </div>
                <div class="col-md-4">
                <label for="estreno" class="form-label">Fecha de Estreno</label>
                <input type="date" name="estreno" class="form-control" placeholder="Fecha de Estreno">
                </div>
                <!-- <div class="col-md-4">
                <label for="estreno" class="form-label">Fecha de Estreno</label>
                <input type="text" name="estreno" class="form-control" placeholder="Fecha de Estreno">
                </div> -->
                <div class="col-md-4">
                <label for="duracion" class="form-label">Duración (Min)</label>
                <input type="text" name="duracion" class="form-control" placeholder="Duración">
                </div>
                <div class="col-md-4">
                <label for="precio" class="form-label">Precio</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">$</span>
                    <input type="text" name="precio" class="form-control" placeholder="Precio">
                </div>  
                </div>
                <div class="col-md-4">
                <label for="genero" class="form-label">Género de Película</label>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Género</label>
                        <select class="form-select" id="inputGroupSelect01" name="genero">
                            <option selected>Elegir</option>
                            <option value="1">Comedia</option>
                            <option value="2">Aventura</option>
                            <option value="3">Drama</option>
                            <option value="4">Acción</option>
                            <option value="5">Musical</option>
                            <option value="6">Documental</option>
                            <option value="7">Horror</option>
                            <option value="8">Romántico</option>
                            <option value="9">Ciencia Ficción</option>
                            <option value="10">Crimen</option>
                        </select>
                </div>
                </div>
                <div class="col-md-4">
                <label for="estudio" class="form-label">Estudio de Filamación</label>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Estudio</label>
                        <select class="form-select" id="inputGroupSelect01" name="estudio">
                            <option selected>Elegir</option>
                            <option value="1">SAS Movie Studio</option>
                            <option value="2">Studios 60</option>
                            <option value="3">Raleigh Studios Hollywood</option>
                            <option value="4">Los Angeles Center Studios</option>
                            <option value="5">Source Fil Studios</option>
                            <option value="6">Hollywood Center Studios</option>
                            <option value="7">RED Studios Hollywood</option>
                            <option value="8">Sunset Bronson Studios</option>
                            <option value="9">Atomic Studios</option>
                            <option value="10">Jades Film Studios</option>
                        </select>
                </div>
                </div>
                <div class="col-md-4">
                <label for="proveedor" class="form-label">Empresa Proveedora</label>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Proveedor</label>
                        <select class="form-select" id="inputGroupSelect01" name="proveedor">
                            <option selected>Elegir</option>
                            <option value="1">KweliTV</option>
                            <option value="2">Tubi</option>
                            <option value="3">GuacaTV</option>
                            <option value="4">MAGIS</option>
                            <option value="5">UserPel</option>
                            <option value="6">Moveflix</option>
                            <option value="7">TeleUser</option>
                            <option value="8">Xenon</option>
                            <option value="9">Planster</option>
                            <option value="10">Fluxor</option>
                        </select>
                </div>
                </div>
                <div class="col-md-4">
                <label for="sinopsis" class="form-label">Sinopsis</label>
                </div>
                <div class="input-group">
                <textarea class="form-control" aria-label="With textarea" name="sinopsis"></textarea>
                </div>
                <div class="col-12">
                <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-dark">Registrar Película</button>
                </div>
            </form>
        </div>";
      <?php
      }
      require('footer.php');
      ?>
<script language='JavaScript' type='text/javascript' src='js/mensajes.js'></script>
</body>
</html>