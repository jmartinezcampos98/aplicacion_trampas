<?php
require "conexion.php";
$conexion = abrir_conexion();
$entrada = $_GET['q'];
$puntos = explode('+', $entrada);
// Borra todos los puntos de la instalacion
if (isset($puntos[0])) {
    $datos = explode(':', $puntos[0]);
    borrar_puntos_instalacion($conexion, $datos[1]);
}
foreach ($puntos as $punto) {
    $datos = explode(':', $punto);
    // $conexion, $num_punto, $id_instalacion, $x_coord, $y_coord, $lugar
    insertar_puntos($conexion, $datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
}



echo("Puntos guardados");
?>
