<?php

function getFakeJsonString(): string
{
    $json_string = '';
    $punto1 = [
        'num_punto' => 0,
        'tipo' => 'INSECTOS_VOLADORES',
        'nombre' => '001IV',
    ];
    $punto2 = [
        'num_punto' => 1,
        'tipo' => 'PORTACEBO SEGURIDAD',
        'nombre' => 'Z0',
    ];
    $punto3 = [
        'num_punto' => 2,
        'tipo' => 'MONITOREO',
        'nombre' => '001IV',
    ];
    $lista_puntos1 = [$punto1, $punto2, $punto3];
    $lista_puntos2 = [];
    $zona1 = [
        'zona' => 'ALMACEN',
        'puntos' => $lista_puntos1,
    ];
    $zona2 = [
        'zona' => 'INSECTOCAPTOR',
        'puntos' => $lista_puntos2,
    ];
    $lista_zonas1 = [$zona1, $zona2];
    $lista_zonas2 = [];
    $instalaciones1 = [
        'instalacion' => '5',
        'zonas' => $lista_zonas1,
    ];
    $instalaciones2 = [
        'instalacion' => '2',
        'zonas' => $lista_zonas2,
    ];
    $lista_instalaciones1 = [$instalaciones1, $instalaciones2];
    $lista_instalaciones2 = [];
    $cliente1 = [
        'cliente' => '115',
        'instalaciones' => $lista_instalaciones1,
    ];
    $cliente2 = [
        'cliente' => '1185',
        'instalaciones' => $lista_instalaciones2,
    ];
    $lista_clientes = [$cliente1, $cliente2];
    return json_encode($lista_clientes);
}
