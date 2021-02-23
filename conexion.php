<?php

function abrir_conexion(): PDO
{
    return new PDO("mysql:host=localhost;dbname=trampas", "root", "");
}

function obtener_puntos(PDO $conexion, $id_instalacion) : array
{
    $consulta = $conexion->prepare(
         "SELECT h.id_instalacion, h.num_punto, h.color, p.lugar, p.x_coord, p.y_coord 
                FROM historial h 
                    LEFT JOIN puntos p ON (h.id_instalacion = p.id_instalacion AND h.num_punto = p.num_punto)
                WHERE (H.ID_INSTALACION, H.NUM_PUNTO, H.FECHA) IN (
                    SELECT sub.id_instalacion, sub.num_punto, MAX(sub.fecha) FROM historial sub GROUP BY sub.id_instalacion, sub.num_punto
                ) AND p.id_instalacion = '" . $id_instalacion . "'
                ORDER BY p.id_instalacion, p.num_punto");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

function obtener_imagen(PDO $conexion, $id_instalacion)
{
    $consulta = $conexion->prepare("SELECT ins.id_instalacion, img.imagen 
                    FROM instalaciones ins LEFT JOIN imagenes img ON ins.id_instalacion = img.id_instalacion
                    WHERE ins.id_instalacion = '" . $id_instalacion . "'");
    $consulta->execute();
    $array_con_imagen = $consulta->fetch(PDO::FETCH_ASSOC);
    return isset($array_con_imagen['imagen']) ? $array_con_imagen['imagen'] : null;
}

// Tan solo
function borrar_puntos_instalacion(PDO $conexion, $id_instalacion)
{
    $borrado_config = $conexion->prepare(" " .
        "DELETE FROM puntos " .
        "WHERE id_instalacion = '" . $id_instalacion . "'");
    $borrado_config->execute();
}

// Tan solo actualiza la configuración, no borra el historial
function insertar_puntos(PDO $conexion, $num_punto, $id_instalacion, $x_coord, $y_coord, $lugar)
{
    $insercion = $conexion->prepare(
        "INSERT INTO PUNTOS (NUM_PUNTO, ID_INSTALACION, X_COORD, Y_COORD, LUGAR) VALUES "
        . "('$num_punto',"
        . "'$id_instalacion',"
        . "'$x_coord',"
        . "'$y_coord',"
        . "'$lugar')"
    );
    $insercion->execute();
}
