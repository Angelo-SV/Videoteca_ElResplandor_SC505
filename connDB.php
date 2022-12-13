<?php
// Conectar al servicio XE (es decir, la base de datos) en la máquina "localhost"
function conectaOracle(){
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    $username = "TEST";             // Use your username
    $password = "test";             // and your password
    $database = "localhost/orcl";   // and the connect string to connect to your database

    $c = oci_connect($username, $password, $database);
    if (!$c) {
        $m = oci_error();
        trigger_error('Could not connect to database: '. $m['message'], E_USER_ERROR);
    }
    return $c;
}

function consultaOracle($query){
    $conexion = conectaOracle();
    $s = oci_parse($conexion, $query);
    if (!$s) {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($s);
    if (!$r) {
        $e = oci_error($s);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    return $r;
}

function insertaOracle($iquery){
    $conexion = conectaOracle();
    $s = oci_parse($conexion, $iquery);
    if (!$s) {
        $e = oci_error($conexion);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_execute($s, OCI_NO_AUTO_COMMIT); 
    oci_commit($conexion);
}

/*$conn = oci_connect('TEST', 'test', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT * FROM employees');
oci_execute($stid);

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";*/

?>