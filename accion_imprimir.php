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
$style_test = new Style($parsedCss);
$style_layout = new Style($parsedCss);
// $style_punto = new Style($parsedCss);
$style_test->set_color("chocolate");
$style_layout->set_margin("0px");
$style_layout->set_border_width("0px");
// $style_punto->set_transform(50);
try {
    $parsedCss->add_style("#h2_instalacion", $style_test);
    $parsedCss->add_style("html", $style_layout);
    // $parsedCss->add_style("punto_interior_pdf", $style_punto);
} catch (\Dompdf\Exception $e) {
}
$dompdf->setCss($parsedCss);
//$dompdf->setPaper([0, 0, 1000, 800]);

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();