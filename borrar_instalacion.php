<?php

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_id = $_POST['id_cliente_borrado'];
$input_instalacion = $_POST['instalacion_borrada'];
// Borra instalacion si la encuentra
$borrado = "DELETE FROM INSTALACIONES WHERE ID_CLIENTE = '$input_id' AND ID_INSTALACION = '$input_instalacion'";
$conexion_datos ->query($borrado);
//
if ($borrado) {
    echo "BORRADA CON ÉXITO";
}

header("Location: /aplicacion_trampas/index.php");
exit;

