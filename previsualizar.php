<?php

require_once "ImpresionTrampas.php";
require_once "conexion.php";

$conexion = abrir_conexion();
$plantilla = new ImpresionTrampas();

$datos = array(
    "imagen" => obtener_imagen($conexion, 'BODEGAS_VEGAMAR_BAJO'),
    "cliente" => 'CARLOS DÍAZ',
    "instalacion" => 'BODEGAS_VEGAMAR_BAJO',
    "puntos" => obtener_puntos($conexion, 'BODEGAS_VEGAMAR_BAJO')
);
echo($plantilla->parsePagina($datos));