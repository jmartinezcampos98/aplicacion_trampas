<?php
require_once "dompdf/autoload.inc.php";
require_once "test_class.php";
require_once "conexion.php";
require_once "ImpresionTrampas.php";
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$plantilla2 = new ImpresionTrampas();

$conexion = abrir_conexion();
$datos = array(
    "imagen" => obtener_imagen($conexion, 'BODEGAS_VEGAMAR_BAJO'),
    "cliente" => "PAQUITA CHURRA",
    "instalacion" => "CHURRERÍA_TÍA_PAQUITA",
    "puntos" => obtener_puntos($conexion, 'BODEGAS_VEGAMAR_BAJO')
);

$dompdf->loadHtml($plantilla2->parsePagina($datos));

// (Optional) Setup the paper size and orientation
//$dompdf2->setPaper('A4', 'landscape');
$dompdf->setPaper([0, 0, 1000, 800]);

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();