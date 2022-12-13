<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/nosotros.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
      .map-container-9,
      .map-container-10,
      .map-container-11 {
        overflow:hidden;
        padding-bottom:56.25%;
        position:relative;
        height:0;
      }

      .map-container-9 iframe,
      .map-container-10 iframe,
      .map-container-11 iframe{
        left:0;
        top:0;
        height:100%;
        width:100%;
        position:absolute;
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
    ?>
    
    <div class="container aboutus-container"> 
      <div class="row featurette">
        <div class="col-md-7 order-md-2 text-container">
          <h2 class="featurette-heading fw-normal lh-1">Videoteca el Resplandor</h2>
          <p class="lead">Videoteca El Resplandor es un espacio que almacena material cinematográfico del mismo modo en que las bibliotecas conservan libros. Nuestra  finalidad es 
            preservar, organizar, catalogar y distribuir el contenido de manera oportuna a nuestros clientes. Con el avance de la tecnología y el auge de la digitalización, ahora las 
            películas pueden ser accesadas a través de nuestros  servidores a través de Internet.</p>  
            <h4 class="featurette-heading fw-normal lh-1">Desarrolladores</h4>
            <p class="lead">Angelo Sotomayor Vargas | Sebastian Lizano Fernandez</p>
            <h4 class="featurette-heading fw-normal lh-1">Curso</h4>
            <p class="lead">Lenguajes de Bases de Datos SC-504</p>
            <h4 class="featurette-heading fw-normal lh-1">Sucursales</h4>
            <p class="lead">Haz click en el siguiente botón para ubicar nuestras sucursales en el mapa.</p>
            <div>
              <button type="button" class="btn btn-dark" id="myBtn">Buscar</button>
            </div>
        </div>
      <div class="col-md-5 order-md-1 texto">
        <img src="img/LogoCompleto.png" class="rounded">
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalMapa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body mb-0 p-0">
          <div id="map-container-google-16" class="z-depth-1-half map-container-9" style="height: 400px">
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3929.570128584374!2d-84.03227856984451!3d9.96967733253825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sus!4v1669072341057!5m2!1ses-419!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <?php
  require('footer.php');
  ?>
  
  <script>
    $(document).ready(function(){
      $("#myBtn").click(function(){
        $("#modalMapa").modal('show');
      });
    });
  </script>

</body>
</html>