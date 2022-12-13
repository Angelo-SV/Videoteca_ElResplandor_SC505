<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link type="text/css" rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    
</head>

<body>
    <!-- Modal -->
    <div class="modal" id="modalLoginError" tabindex="-1" aria-labelledby="modalLoginError" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error al Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>El correo electrónico/contraseña son incorrectos</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalLoginError2" tabindex="-1" aria-labelledby="modalLoginError2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error al Iniciar Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>El correo electrónico ingresado aún no se encuentra registrado</p>
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

    if (isset($_SESSION['correo'])) {
        header("Location: index.php");
	} else if (isset($_POST['correo'])) {
        
		$correo = $_REQUEST['correo'];
		$contrasena = $_REQUEST['contrasena'];

		/*$correoQuery = "SELECT COUNT(*) FROM USUARIOS WHERE CORREO ='$correo'";*/
        $func = "SELECT SERVICIOS_VARIOS.VALIDA_CORREO('$correo') FROM DUAL";
        $stmt = oci_parse(conectaOracle(), $func);
        oci_execute($stmt);

        $numrows = null;

        while (($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
            foreach ($row as $numrows) {
                /*print "  <p>$numrows</p>";*/
            }
        }
        
        /*$usuarioQuery = "SELECT CORREO, CONTRASENA, ROL, ID_USUARIO FROM USUARIOS WHERE CORREO ='$correo'";
        $usuario = oci_parse(conectaOracle(), $usuarioQuery);
        oci_execute($usuario);*/

        $func = "SELECT CONSULTA_CREDENCIALES_CORREO('$correo') AS DATOS FROM DUAL";
        $result = oci_parse(conectaOracle(), $func);
        oci_execute($result);

		if ($numrows == 1) {
            $row = oci_fetch_array($result, OCI_ASSOC);
            $data = $row['DATOS'];
            oci_execute($data);
            $data_row = oci_fetch_array($data, OCI_ASSOC);
		} 

		if (!empty($data_row) && password_verify($contrasena, $data_row['CONTRASENA'])) {
			/*session_start()*/
			$_SESSION['correo'] = $data_row['CORREO'];
			$_SESSION['id'] = $data_row['ID_USUARIO'];
			$_SESSION['rol'] = $data_row['ROL'];
			header("Location: index.php");
		} else if(empty($data_row)){
			formW();
			echo '<script type="text/javascript"> $(document).ready(function() {modalLoginError2();});</script>';

		}else {
			formW();
			echo '<script type="text/javascript"> $(document).ready(function() {modalLoginError();});</script>';
		}
	} else {
		formW();
	}

    function formW(){
        ?>
        <div>
            <section id="content">
                <div class="content-wrap">
                    <div class="container login">
                        <div class="row justify-content-center">
                            <div class="col-lg-7 col-md-10">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-center">Accede a tu Perfil</h4>
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
        
                                            <form class="mb-0" id="loginForm" name="loginForm" action="" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-12 bottommargin-sm" id="space">
                                                        <label for="template-contactform-email">Correo Electrónico<small class="text-danger">*</small></label>
                                                        <input type="email" name="correo" id="correo" class="form-control required" value="" placeholder="ejemplo@correo.com">
                                                    </div>
        
                                                    <div class="col-12 bottommargin-sm" id="space">
                                                        <label for="template-contactform-password">Contraseña:<small class="text-danger">*</small></label>
                                                        <input type="password" id="contrasena" name="contrasena" value="" class="form-control" placeholder="Ingrese su Contraseña" />
                                                    </div>
        
                                                    <div class="col-12" id="space">
                                                        <button type="submit" name="template-contactform-submit" class="btn btn-dark w-100 btn-lg">Iniciar Sesión</button>
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