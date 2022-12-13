<?php

function muestraEstado(){
    
    
    $id = $_REQUEST["idUser"];

    $funCount = "SELECT SERVICIOS_VARIOS.VALIDA_USUARIO('$id') FROM DUAL";
    $stmt2 = oci_parse(conectaOracle(), $funCount);
    oci_execute($stmt2);

    $numrows = null;

    while (($rows = oci_fetch_array($stmt2, OCI_ASSOC+OCI_RETURN_NULLS)) != false){
        foreach ($rows as $numrows) {
        }
    }

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
?>