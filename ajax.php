<?php
require "conexion.php";
$conexion = abrir_conexion();
$entrada = $_GET['q'];
$puntos = explode('+', $entrada);
$error = false;
// Borra todos los puntos de la instalacion
if (isset($puntos[0])) {
    $datos = explode(':', $puntos[0]);
    if (isset($datos[1])) {
        borrar_puntos_mapa($conexion, $datos[1]);
    } else {
        $error = $error || true;
    }
}

foreach ($puntos as $punto) {
    $datos = explode(':', $punto);
    // $conexion, $num_punto, $id_instalacion, $x_coord, $y_coord, $lugar
    if (isset($datos[0]) && isset($datos[1]) && isset($datos[2]) && isset($datos[3]) && isset($datos[4])) {
        insertar_punto($conexion, $datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
    } else {
        $error = $error || true;
    }
}

if ($error) {
    echo("Problema al insertar puntos");
} else {
    echo("Puntos guardados");
}



?>
