
<?php

// el proceso de guardar debería estar presente en una página de configuración específica, para no alterar
// los otros procesos

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_id_instalacion = $_POST['id_instalacion'];
// Borra imagen actualmente almacenada
$borrado = "DELETE FROM IMAGENES WHERE ID_INSTALACION = '$input_id_instalacion'";
$resultado = $conexion_datos ->query($borrado);
//
if ($resultado) {
    echo "BORRADO CON ÉXITO";
} else {
    echo "MÁS SUERTE LA PRÓXIMA VEZ";
}

header('HTTP/1.1 307 Temporary Redirect');
header("Location: /aplicacion_trampas/index.php");
exit;