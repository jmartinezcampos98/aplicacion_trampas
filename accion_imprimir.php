<?php
require_once "dompdf/autoload.inc.php";
require_once "conexion.php";
require_once "ImpresionTrampas.php";

use Dompdf\Css\Style;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$plantilla = new ImpresionTrampas();

$input_id_cliente = $_POST['id_cliente'];
$input_nombre_cliente = $_POST['nombre_cliente'];
$input_instalacion = $_POST['id_instalacion'];

$conexion = abrir_conexion();
$datos = array(
    "imagen" => obtener_imagen($conexion, $input_instalacion),
    "cliente" => $input_nombre_cliente,
    "instalacion" => $input_instalacion,
    "puntos" => obtener_puntos($conexion, $input_instalacion)
);

$dompdf->loadHtml($plantilla->parsePagina($datos));

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$parsedCss = new Stylesheet($dompdf);
$style = new Style($parsedCss);
$style->set_color("chocolate");
try {
    $parsedCss->add_style("#h2_instalacion", $style);
} catch (\Dompdf\Exception $e) {
}
$dompdf->setCss($parsedCss);
//$dompdf->setPaper([0, 0, 1000, 800]);

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();