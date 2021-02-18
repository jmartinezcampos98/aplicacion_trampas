<?php

function abrir_conexion(): PDO
{
    return new PDO("mysql:host=localhost;dbname=trampas", "root", "");
}

function obtener_puntos(PDO $conexion, $id_instalacion) : array
{
    $consulta = $conexion->prepare("SELECT ins.id_instalacion, p.num_punto, p.lugar, p.color, p.x_coord, p.y_coord
                    FROM instalaciones ins, puntos p
                    WHERE ins.id_instalacion = p.id_instalacion 
                      AND ins.id_instalacion = '" . $id_instalacion . "'
                    ORDER BY INS.ID_CLIENTE, INS.ID_INSTALACION, P.NUM_PUNTO");
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
