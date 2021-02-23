<?php


// Conecta a base de datos
require_once("conexion.php");
$conexion = abrir_conexion();

$consulta = $conexion->prepare("SELECT p.id_instalacion, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord
    FROM puntos p
    WHERE p.id_instalacion = 'BODEGAS_VEGAMAR_BAJO' AND
        p.fecha = (SELECT MAX(fecha) FROM puntos)
    ORDER BY P.NUM_PUNTO");
$consulta->execute();
$datos_instalaciones = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
?>

