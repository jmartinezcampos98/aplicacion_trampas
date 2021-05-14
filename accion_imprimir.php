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

$fecha_inicio = [
    'anyo' => $_POST['anyo_inicio'],
    'mes' => $_POST['mes_inicio'],
    'dia' => $_POST['dia_inicio'],
];
$fecha_fin = [
    'anyo' => $_POST['anyo_fin'],
    'mes' => $_POST['mes_fin'],
    'dia' => $_POST['dia_fin'],
];

$conexion = abrir_conexion();
$datos = array(
    "imagen" => obtener_datos_mapa($conexion, $input_instalacion),
    "cliente" => $input_nombre_cliente,
    "instalacion" => $input_instalacion,
    "puntos" => obtener_puntos_entre_fechas($conexion, $input_instalacion, $fecha_inicio, $fecha_fin)
);

for ($i = 0; $i < sizeof($datos['puntos']); $i++) {
    if ($datos['puntos'][$i]['color'] == 0) {
        $datos['puntos'][$i]['color'] = "0";
    } else if ($datos['puntos'][$i]['color'] == 2) {
        $datos['puntos'][$i]['color'] = "2";
    } else {
        $datos['puntos'][$i]['color'] = "1";
    }
}

$puntos_debug = obtener_puntos($conexion, $input_instalacion);

$dompdf->loadHtml($plantilla->parsePagina($datos, $fecha_inicio, $fecha_fin));

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