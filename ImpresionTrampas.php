<?php


class ImpresionTrampas
{



    public function parsePagina(array $datos): string
    {
        $html_string = '';
        $html_string .= '<html>
        <head>
            <title>Herramienta de trampas</title>
            <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
            <script src="js/comportamiento.js"></script>
        </head>
        <body marginheight="0px" marginwidth="0px">
            <div>
                <div class="simple">'.
                    '<img class="imagen_plano" <img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($datos["imagen"]).'"/>'.
                '</div>
                <div>
                    <br/>
                    <div class="margen_izquierda" action="index.php" method="POST">
                        <h2>Cliente: ' . $datos["cliente"] . '</h2> 
                        <h2>Instalación: ' . $datos["instalacion"] . '</h2>
                    </div>
                    <!-- AQUI LOS PUNTOS -->
                </div>
            </div>
            <div id="puntos_pantalla">';
        foreach ($datos["puntos"] as $punto) {
            $id_instalacion = $punto["id_instalacion"];
            $xCoord = $punto["x_coord"];
            $yCoord = $punto["y_coord"];
            $color_dato = $punto["color"];
            switch ($color_dato) {
                case 2:
                    // Verde
                    $color_hex = "#008000";
                    break;
                case 1:
                    // Amarillo
                    $color_hex = "#FFFF00";
                    break;
                default:
                    // Rojo
                    $color_hex = "#FF0000";
                    break;
            }
            $nombre = $punto["lugar"];
            $html_string .=
                '<div style="background-color: white; position: absolute; left: ' . $xCoord . 'px; top: ' . $yCoord . 'px;'.
                    'width: 15px; height: 15px;">
                ';
                // '<span class="dot punto_redondo exterior" style="background-color: white;"></span>';
            $html_string .=
                '<span style="background-color: ' . $color_hex. '; border-radius: 50%; display: inline-block; '.
                    'position: relative; height: 19px; width: 19px;"></span>
                ';
                // '<span class="dot punto_redondo interior" style="background-color: ' + color + ';"></span>'
                /*
                '<div style="position: absolute; left: ' . $xCoord . 'px; right: ' . $yCoord . 'px;'.
                    'width: 15px; height: 15px; border-radius: 50%;">*/
                $html_string .= '</div>
                ';

        }
        // fin de puntosPantalla
        $html_string .=
            '</div>
                ';
        $html_string .= '</body>
        </html>';
        return $html_string;
    }
}