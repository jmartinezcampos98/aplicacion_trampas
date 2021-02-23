<?php
require_once "dompdf/autoload.inc.php";
require_once "test_class.php";
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$plantilla = new test_class();

$dompdf->loadHtml($plantilla->parsePagina());

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();