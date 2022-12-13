<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link type="text/css" rel="stylesheet" href="css/registro.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <!-- Modal -->
    <div class="modal" id="modalRegistroError" tabindex="-1" aria-labelledby="modalRegistroError" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error al Registrar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>El correo electrónico utilizado ya se encuentra registrado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalRegistroExito" tabindex="-1" aria-labelledby="modalRegistroExito" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¡Registro exitoso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¡Se ha registrado exitosamente!</p>
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

    function passwordHash($stringVar){
        $stringVar = stripslashes($stringVar);
        $stringVar = password_hash($stringVar, PASSWORD_BCRYPT);
        return $stringVar;
    }

    if (isset($_REQUEST['correo'])){
        $nombre = $_REQUEST['nombre'];
        $apellido1 = $_REQUEST['apellido1'];
        $apellido2 = $_REQUEST['apellido2'];
        $correo = $_REQUEST['correo'];
        $telefono = $_REQUEST['telefono'];
        $direccion = $_REQUEST['direccion'];
        $contrasena = passwordHash($_REQUEST['contrasena']);
        $rol = $_REQUEST['rol'];
        $morosidad = $_REQUEST['morosidad'];

        $nombreOk     = false;
        $apellido1Ok  = false;
        $apellido2Ok  = false;
        $correoOk     = false;
        $telefonoOk   = false;
        $direccionOk  = false;
        $contrasenaOk = false;
        $morosidadOk  = true;
        $rolOk        = true;
              
        if ($nombre == "") {
            print "  <p class=\"aviso\">No ha ingresado su nombre.</p>\n";
            print "\n";
        } else {
            $nombreOk = true;
        }

        if ($apellido1 == "") {
            print "  <p class=\"aviso\">No ha ingresado su primer apellido.</p>\n";
            print "\n";
        } else {
            $apellido1Ok = true;
        }

        if ($apellido2 == "") {
            print "  <p class=\"aviso\">No ha ingresado su segundo apellido.</p>\n";
            print "\n";
        } else {
            $apellido2Ok = true;
        }

        if ($correo == "") {
            print "  <p class=\"aviso\">No ha ingresado el correo electrónico.</p>\n";
            print "\n";
        } else {
            $correoOk = true;
        }
    
        if ($telefono == "") {
            print "  <p class=\"aviso\">No ha ingresado el número de teléfono.</p>\n";
            print "\n";
        } else {
            $telefonoOk = true;
        }

        if ($direccion == "") {
            print "  <p class=\"aviso\">No ha ingresado el número de teléfono.</p>\n";
            print "\n";
        } else {
            $direccionOk = true;
        }

        if ($contrasena == "") {
            print "  <p class=\"aviso\">No ha ingresado la contraseña.</p>\n";
            print "\n";
        } else {
            $contrasenaOk = true;
        }

        if($nombreOk && $apellido1Ok && $apellido2Ok && $correoOk && $telefonoOk && $direccionOk && $contrasenaOk && $rolOk && $morosidadOk){
            /*$correoQuery = "SELECT COUNT(CORREO) FROM USUARIOS WHERE CORREO ='$correo'";*/

            $func = "SELECT SERVICIOS_VARIOS.VALIDA_CORREO('$correo') FROM DUAL";
            $stmt = oci_parse(conectaOracle(), $func);
            oci_execute($stmt);

            $numrows = null;

            while (($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
                foreach ($row as $numrows) {
                    /*print "  <p>$numrows</p>";*/
                }
            }

            if ($numrows == 0){
                /*$iquery = "INSERT INTO USUARIOS (NOMBRE, APELLIDO_PATERNO, APELLIDO_MATERNO, CORREO, TELEFONO, DIRECCION, CONTRASENA, ROL, MOROSIDAD) 
                VALUES ('$nombre','$apellido1','$apellido2', '$correo', '$telefono', '$direccion ', '$contrasena', '$rol', '$morosidad')";*/
                
                $proced = "BEGIN INSERTAR_USUARIO('$nombre','$apellido1','$apellido2', '$correo', '$telefono', '$direccion ', '$contrasena', '$rol', '$morosidad'); END;";
                $result = oci_parse(conectaOracle(), $proced);

                if($result){
                    oci_execute($result, OCI_NO_AUTO_COMMIT); 
                    oci_commit(conectaOracle());

                    formW();
                    echo '<script type="text/javascript"> $(document).ready(function() {modalRegistroExito();});</script>';
                } 
            } else {
                formW();
                    echo '<script type="text/javascript"> $(document).ready(function() {modalRegistroError();});</script>';
            }
        }
    } else {
        formW();
    }

    function formW(){
        ?>
        <div class="register">
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-md-10">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h4 class="mb-0 text-center">Registrate para Acceder a Nuestros Servicios</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-widget">
                                        <div class="form-result"></div>
                                        <div class="form-process">
                                            <div class="css3-spinner">
                                                <div class="css3-spinner-double-bounce1"></div>
                                                <div class="css3-spinner-double-bounce2"></div>
                                            </div>
                                        </div>
                                        <form class="mb-0" id="registroform" name="registroform" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-12 bottommargin-sm" id="space">
													<label for="template-contactform-name">Nombre<small class="text-danger">*</small></label>
													<input type="text" id="nombre" name="nombre" class="form-control required" placeholder="Ingresa tu Nombre" />
												</div>
                                                <div class="col-12 bottommargin-sm" id="space">
													<label for="template-contactform-name">Primer Apellido<small class="text-danger">*</small></label>
													<input type="text" id="apellido1" name="apellido1" class="form-control required" placeholder="Ingresa tus Apellidos" />
												</div>
                                                <div class="col-12 bottommargin-sm" id="space">
													<label for="template-contactform-name">Segundo Apellido<small class="text-danger">*</small></label>
													<input type="text" id="apellido2" name="apellido2" class="form-control required" placeholder="Ingresa tus Apellidos" />
												</div>
                                                <div class="col-12 bottommargin-sm" id="space">
                                                    <label for="template-contactform-email">Correo Electrónico<small class="text-danger">*</small></label>
                                                    <input type="email" name="correo" id="correo" class="form-control required" placeholder="ejemplo@correo.com">
                                                </div>
                                                <div class="col-12 bottommargin-sm" id="space">
													<label for="template-contactform-phone">Teléfono</label>
													<input type="tel" id="telefono" name="telefono" class="form-control required" placeholder="Ingresa tu Número de Teléfono" />
												</div>
                                                <div class="col-12 bottommargin-sm" id="space">
													<label for="template-contactform-name">Dirección<small class="text-danger">*</small></label>
													<input type="text" id="direccion" name="direccion" class="form-control required" placeholder="Ingresa una breve dirección" />
												</div>
                                                <div class="col-12 bottommargin-sm" id="space">
                                                    <label for="template-contactform-password">Contraseña<small class="text-danger">*</small></label>
                                                    <input type="password" id="contrasena" name="contrasena" class="form-control required" placeholder="Crea una Contraseña" />
                                                </div>
                                                    <input type="hidden" id="rol" name="rol" value="1"/>
                                                    <input type="hidden" id="morosidad" name="morosidad" value="1"/>
                                                <div class="col-12" id="space">
                                                    <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-dark w-100 btn-lg">¡Registrarme!</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
      </div>
      <?php
      }
      require('footer.php');
      ?>
<script language='JavaScript' type='text/javascript' src='js/mensajes.js'></script>
</body>
</html>