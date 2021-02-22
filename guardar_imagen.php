<?php

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_id_instalacion = $_POST['id_instalacion'];
$input_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
// Borra imagen actualmente almacenada
$borrado = "DELETE FROM IMAGENES WHERE ID_INSTALACION = '$input_id_instalacion'";
$conexion_datos ->query($borrado);
// Almacena en base de datos
$insercion = "INSERT INTO IMAGENES (ID_INSTALACION, IMAGEN) VALUES ('$input_id_instalacion', '$input_imagen')";
$resultado = $conexion_datos->query($insercion);
//
if ($resultado) {
    echo "INSERTADO CON ÉXITO";
}

header('HTTP/1.1 307 Temporary Redirect');
header("Location: /aplicacion_trampas/index.php");
exit;

