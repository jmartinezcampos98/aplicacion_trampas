<?php

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_cliente = $_POST['cliente'];
$input_instalacion = $_POST['instalacion'];
$input_zona = $_POST['zona'];
// Borra imagen actualmente almacenada
$borrado = "UPDATE MAPAS SET IMAGEN = NULL "
            ." WHERE CLIENTE = '$input_cliente'"
                ." AND INSTALACION = '$input_instalacion'"
                ." AND ZONA = '$input_zona'";
$resultado = $conexion_datos ->query($borrado);
//
if ($resultado) {
    echo "BORRADO CON ÉXITO";
}

header('HTTP/1.1 307 Temporary Redirect');
header("Location: /aplicacion_trampas/index.php");
exit;