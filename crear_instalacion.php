<?php

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_cliente = $_POST['nombre_cliente_creado'];
$input_id = $_POST['id_cliente_creado'];
$input_instalacion = $_POST['instalacion_creada'];
// Borra instalacion si la encuentra
$borrado = "DELETE FROM INSTALACIONES WHERE ID_CLIENTE = '$input_id' AND ID_INSTALACION = '$input_instalacion'";
$conexion_datos ->query($borrado);
// Almacena en base de datos
$insercion = "INSERT INTO INSTALACIONES (ID_CLIENTE, NOMBRE_CLIENTE, ID_INSTALACION) VALUES ('$input_id', '$input_cliente', '$input_instalacion')";
$resultado = $conexion_datos->query($insercion);
//
if ($resultado) {
    echo "INSERTADA CON ÉXITO";
}

header('HTTP/1.1 307 Temporary Redirect');
header("Location: /aplicacion_trampas/index.php");
exit;

