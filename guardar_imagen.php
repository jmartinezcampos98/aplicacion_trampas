<?php

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_cliente = $_POST['cliente'];
$input_instalacion = $_POST['instalacion'];
$input_zona = $_POST['zona'];
$input_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
// Borra imagen actualmente almacenada
$actualizacion = "UPDATE mapas SET IMAGEN = '$input_imagen' "
                ." WHERE CLIENTE = '$input_cliente'"
                    ." AND INSTALACION = '$input_instalacion'"
                    ." AND ZONA = '$input_zona'";
$resultado = $conexion_datos->query($actualizacion);
//
if ($resultado) {
    echo "INSERTADO CON ÉXITO";
}

header('HTTP/1.1 307 Temporary Redirect');
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

