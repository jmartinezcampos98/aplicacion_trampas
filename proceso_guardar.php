
<?php

// el proceso de guardar debería estar presente en una página de configuración específica, para no alterar
// los otros procesos

include("conexion.php");

// Conecta a base de datos
$conexion_datos = abrir_conexion();
// Obtiene las variables del formulario
$input_id_instalacion = $_POST['id_instalacion'];
$input_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
// Almacena en base de datos
$query = "INSERT INTO IMAGENES (ID_INSTALACION, IMAGEN) VALUES ('$input_id_instalacion', '$input_imagen')";
$resultado = $conexion_datos->query($query);
//
if ($resultado) {
    echo "INSERTADO CON ÉXITO";
} else {
    echo "MÁS SUERTE LA PRÓXIMA VEZ";
}

// en cualquier caso, debería redirigir después hacia la página principal

