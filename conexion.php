<?php

function abrir_conexion(): PDO
{
    return new PDO("mysql:host=localhost;dbname=trampas", "root", "");
}

function obtener_datos_mapa(PDO $conexion, string $id_cliente, string $id_instalacion, string $id_zona): ?array
{
    $sql = "SELECT ID_MAPA, IMAGEN "
        ." FROM MAPAS "
        ." WHERE CLIENTE = '" . $id_cliente . "' "
        ." AND INSTALACION = '" . $id_instalacion . "' "
        ." AND ZONA = '" . $id_zona . "'";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    return $resultado ?? null;
}

function obtener_puntos(PDO $conexion, int $id_mapa) : array
{
    $sql = "SELECT ID_MAPA, NUM_PUNTO, TIPO, NOMBRE, X_COORD, Y_COORD "
        ." FROM PUNTOS "
        ." WHERE ID_MAPA = '" . $id_mapa . "'"
        ." ORDER BY ID_MAPA, NUM_PUNTO";
    $consulta = $conexion->prepare($sql);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function borrar_puntos_mapa(PDO $conexion, int $id_mapa) : void
{
    $sql = "DELETE FROM PUNTOS WHERE ID_MAPA = '" . $id_mapa . "' ";
    $borrado_config = $conexion->prepare($sql);
    $borrado_config->execute();
}

function borrar_punto_mapa(PDO $conexion, int $id_mapa, int $num_punto) : void
{
    $sql = "DELETE FROM PUNTOS WHERE ID_MAPA = '" . $id_mapa . "' AND NUM_PUNTO = '" . $num_punto . "'";
    $borrado_config = $conexion->prepare($sql);
    $borrado_config->execute();
}

function insertar_punto(PDO $conexion, int $id_mapa, int $num_punto,
                        string $tipo, string $nombre, int $x_coord, int $y_coord) : array | bool
{
    $sql = "INSERT INTO PUNTOS (ID_MAPA, NUM_PUNTO, TIPO, NOMBRE, X_COORD, Y_COORD) VALUES "
        ." ('" . $id_mapa . "', "
        . " '" . $num_punto . "', "
        . " '" . $tipo . "', "
        . " '" . $nombre . "', "
        . " '" . $x_coord . "', "
        . " '" . $y_coord . "')";
    $insercion = $conexion->prepare($sql);
    try {
        if ($exito = $insercion->execute()) {
            $creado = [
                "id_mapa" => $id_mapa,
                "num_punto" => $num_punto,
                "tipo" => $tipo,
                "nombre" => $nombre,
                "x_coord" => $x_coord,
                "y_coord" => $y_coord,
            ];
            return $creado;
        } else {
            return $exito;
        }
    } catch (Exception $e) {
        return false;
    }
}
