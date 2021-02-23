<?php
require_once "dompdf/autoload.inc.php";
require_once "test_class.php";
require_once "conexion.php";
require_once "ImpresionTrampas.php";
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$plantilla2 = new ImpresionTrampas();
$plantilla = new test_class();

$conexion = abrir_conexion();

$datos = array(
    "imagen" => obtener_imagen($conexion, 'BODEGAS_VEGAMAR_BAJO'),
    "cliente" => "PAQUITA CHURRA",
    "instalacion" => "CHURRERÍA_TÍA_PAQUITA"
);

//$dompdf->loadHtml($plantilla->parsePagina());
$pagina = $plantilla2->parsePagina($datos);

$dompdf->loadHtml($pagina);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

echo($pagina);