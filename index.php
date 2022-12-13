<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Resplandor</title>
    <link type="text/css" rel="stylesheet" href="css/estilos.css">
    <link type="text/css" rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/normalize.css">
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  
<body class="main-container">
  <?php
  require('navbar.php');
  ?>
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="img/bestiabanner.jpg" class="d-block w-100" alt="Películas Animadas">
            <div class="carousel-caption d-none d-md-block">
              <h5>Próximos Estrenos</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/nweDEzNssGUe7tMFO0VFEctsFxe9gebTUta6FyXg.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Las Mejores Películas</h5>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/filme-elvis.png" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Todos los Géneros</h5>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      <?php
      require('connDB.php');
      $consultaPelicula1 = "SELECT * FROM PELICULA_1";
      $stmt = oci_parse(conectaOracle(), $consultaPelicula1);
      oci_execute($stmt);
      $row = oci_fetch_assoc($stmt);

      if (!empty($row) ) {
          $id1 = $row['ID_PELICULA'];
          $title1 = $row['TITULO'];
          $synopsis1 = $row['SINOPSIS'];
      }

      $consultaPelicula2 = "SELECT * FROM PELICULA_2";
      $stmt2 = oci_parse(conectaOracle(), $consultaPelicula2);
      oci_execute($stmt2);
      $row = oci_fetch_assoc($stmt2);

      if (!empty($row) ) {
          $id2= $row['ID_PELICULA'];
          $title2 = $row['TITULO'];
          $synopsis2 = $row['SINOPSIS'];
      }

      $consultaPelicula3 = "SELECT * FROM PELICULA_3";
      $stmt3 = oci_parse(conectaOracle(), $consultaPelicula3);
      oci_execute($stmt3);
      $row = oci_fetch_assoc($stmt3);

      if (!empty($row) ) {
          $id3= $row['ID_PELICULA'];
          $title3 = $row['TITULO'];
          $synopsis3 = $row['SINOPSIS'];
      }

      $consultaPelicula4 = "SELECT * FROM PELICULA_4";
      $stmt4 = oci_parse(conectaOracle(), $consultaPelicula4);
      oci_execute($stmt4);
      $row = oci_fetch_assoc($stmt4);

      if (!empty($row) ) {
          $id4= $row['ID_PELICULA'];
          $title4 = $row['TITULO'];
          $synopsis4 = $row['SINOPSIS'];
      }

      $consultaPelicula5 = "SELECT * FROM PELICULA_5";
      $stmt5 = oci_parse(conectaOracle(), $consultaPelicula5);
      oci_execute($stmt5);
      $row = oci_fetch_assoc($stmt5);

      if (!empty($row) ) {
          $id5= $row['ID_PELICULA'];
          $title5 = $row['TITULO'];
          $synopsis5 = $row['SINOPSIS'];
      }
      ?>
    
      <div class="movies-container" id="1">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/doctor_strange_en_el_multiverso_de_la_locura_92243.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $title1?></h5>
              <p class="card-text"><?php echo $synopsis1?></p>
            </div>
            <div class="card-footer card border-warning mb-3 ">
              <?php echo "<a href=carrito.php?idPelicula=" . $id1 . " class=\"btn btn-primary btn btn-warning\">Comprar</a>"?>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/teaser-poster-super-mario-2022-original.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $title2?></h5>
              <p class="card-text"><?php echo $synopsis2?>​</p>
            </div>
            <div class="card-footer card border-warning mb-3">
            <?php echo "<a href=carrito.php?idPelicula=" . $id2 . " class=\"btn btn-primary btn btn-warning\">Comprar</a>"?>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/avatar-reestreno-2.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $title3?></h5>
              <p class="card-text"><?php echo $synopsis3?></p>
            </div>
            <div class="card-footer card border-warning mb-3">
              <?php echo "<a href=carrito.php?idPelicula=" . $id3 . " class=\"btn btn-primary btn btn-warning\">Comprar</a>"?>
           </div>
          </div>
        </div>
      </div>

      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/1_cb8bc30f.jpeg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title"><?php echo $title4?></h5>
              <p class="card-text"><?php echo $synopsis4?></p>
            </div>
            <div class="card-footer card border-warning mb-3 ">
              <?php echo "<a href=carrito.php?idPelicula=" . $id4 . " class=\"btn btn-primary btn btn-warning\">Comprar</a>"?>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/VNAZQ4FBVJDLXNM7CR2ZU42X2Y.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
            <h5 class="card-title"><?php echo $title5?></h5>
              <p class="card-text"><?php echo $synopsis5?></p>
            </div>
            <div class="card-footer card border-warning mb-3 ">
              <?php echo "<a href=carrito.php?idPelicula=" . $id5 . " class=\"btn btn-primary btn btn-warning\">Comprar</a>"?>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/1643266354_692817_1643266442_sumario_normal.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Batman</h5>
              <p class="card-text">Batman explora la corrupción existente en la ciudad de Gotham y el vínculo de esta con su propia 
                familia. Enfrentará al villano conocido como "el Acertijo".</p>
            </div>
            <div class="card-footer card border-warning mb-3">
              <a href="#" class="btn btn-primary btn btn-warning">Comprar</a>
            </div>
          </div>
        </div>
      </div>

      <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/4629726.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Smile</h5>
              <p class="card-text">Tras presenciar el dramático incidente sufrido por un paciente, la Dra. Cotter empieza a experimentar 
                hechos aterradores sin explicación aparente.</p>
            </div>
            <div class="card-footer card border-warning mb-3">
              <a href="#" class="btn btn-primary btn btn-warning">Comprar</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/Black-Adam-poster-819x1024.jpeg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Black Adam</h5>
              <p class="card-text">Producida por DC Films, New Line Cinema, Seven Bucks Productions y FlynnPictureCo., y distribuida por 
                Warner Bros. Pictures, pretende ser una derivación de ¡Shazam!</p>
            </div>
            <div class="card-footer card border-warning mb-3">
              <a href="#" class="btn btn-primary btn btn-warning">Comprar</a>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card h-90 card border-dark mb-3 text-bg-dark mb-3">
            <img src="img/fl0u5uixwaazev7_cphe.jpg" height="800px" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Sonic the Hedgehog 2</h5>
              <p class="card-text">Sonic y su compañero Tails emprenden un viaje alrededor del mundo en busca de una esmeralda que tiene 
                del poder de destruir civilizaciones y detener al malvado Eggman.</p>
            </div>

            <div class="card-footer card border-warning mb-3">
              <a href="#" class="btn btn-primary btn btn-warning">Comprar</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    require('footer.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>