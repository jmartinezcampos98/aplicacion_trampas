<?php


class ImpresionTrampas
{
    public function parsePagina(array $datos): string
    {
        $html_string = '';
        $html_string .= '<html>
        <head>
            <title>Herramienta de trampas</title>
            <style>
                #pagina_exportada {
                    background: white;
                    display: block;
                    margin: 0 auto 0.5cm;
                    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
                    height: 21cm;
                    width: 29.7cm;
                }
                
                img.imagen_plano {
                    width: 80%;
                    border: 10px double;
                    position: relative;
                }
                
                div.simple {
                    width: 100%;
                }
                
                span.texto_imagen {
                    position: absolute;
                    left: 270px;
                    top: 140px;
                    margin: auto;
                    background-color: white;
                    font-family: "Arial Black" ;
                }
                
                span.texto_puntos {
                    color: black;
                    background-color: white;
                    position: relative;
                    bottom: 15px;
                }
                
                span.punto_redondo {
                    border-radius: 50%;
                    display: inline-block;
                    position: relative;
                }
                
                span.interior {
                    height: 15px;
                    width: 15px;
                    top: -17px;
                    left: 2px;
                }
                
                span.exterior {
                    height: 19px;
                    width: 19px;
                }
                
                .margen_izquierda {
                    position:relative;
                    margin-left: 10px;
                }
                
                .margen_arriba {
                    position:relative;
                    margin-top: 5px;
                }
                
                .margen_abajo {
                    position:relative;
                    margin-bottom: 5px;
                }
                
                .doble_margen_abajo {
                    position: relative;
                    margin-bottom: 15px;
                }
                
                input.fecha {
                    width: 50px;
                    text-align: right;
                }
            </style>
            <script src="js/comportamiento.js"></script>
        </head>
        <body marginheight="0px" marginwidth="0px">
            <div id="pagina_exportada">
                <div class="simple">'.
                    '<img class="imagen_plano" <img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($datos["imagen"]).'"/>'.
                '</div>
                <div>
                    <br/>
                    <div class="margen_izquierda" action="index.php" method="POST">
                        <h2 id="h2_cliente">Cliente: ' . $datos["cliente"] . '</h2> 
                        <h2 id="h2_instalacion">Instalación: ' . $datos["instalacion"] . '</h2>
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