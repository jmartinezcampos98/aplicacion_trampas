<?php
require "conexion.php";
$conexion = abrir_conexion();
$puntos = $_POST['puntos'];
$mapa = $_POST['id_mapa'];
$exito = true;
// Borra todos los puntos de la instalacion
if (isset($puntos) && sizeof($puntos) >= 1) {
    borrar_puntos_mapa($conexion, $mapa);
}

foreach ($puntos as $punto) {
    // $conexion, $num_punto, $id_instalacion, $x_coord, $y_coord, $lugar
    if (isset($punto['num_punto']) && isset($punto['tipo']) && isset($punto['nombre']) && isset($punto['x_coord']) && isset($punto['y_coord'])) {
        // int $id_mapa, int $num_punto, string $tipo, string $nombre, int $x_coord, int $y_coord
        $exito = insertar_punto($conexion, $mapa, $punto['num_punto'], $punto['tipo'],
            $punto['nombre'], $punto['x_coord'], $punto['y_coord']) && $exito;
    } else {
        $exito = false;
    }
}

if ($exito) {
    $message = ['message'=> "Puntos guardados"];
} else {
    $message = ['message'=> "Problema al insertar puntos"];
}
echo(json_encode($message));

