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
                
                .imagen_plano {
                    width: 80%;
                    border: 5px double;
                    position: absolute;
                }
                
                .simple {
                    width: 100%;
                }
                
                .texto_imagen {
                    position: absolute;
                    left: 270px;
                    top: 140px;
                    margin: auto;
                    background-color: white;
                    font-family: "Arial Black" ;
                }
                
                .texto_puntos {
                    color: black;
                    background-color: white;
                    position: absolute;
                    bottom: 15px;
                }
                
                .punto_redondo {
                    border-radius: 50%;
                    display: inline-block;
                    position: absolute;
                }
                
                .interior {
                    height: 15px;
                    width: 15px;
                    left: 2px;
                    top: 2px;
                }
                
                .exterior {
                    height: 19px;
                    width: 19px;
                }
                
                .margen_izquierda {
                    position:absolute;
                    margin-left: 10px;
                }
                
                .margen_arriba {
                    position:absolute;
                    margin-top: 5px;
                }
                
                .margen_abajo {
                    position:absolute;
                    margin-bottom: 5px;
                }
                
                .doble_margen_abajo {
                    position: absolute;
                    margin-bottom: 15px;
                }
                .contenedor_punto {
                    position: absolute;
                    z-index: 5;
                }
                .fecha {
                    width: 50px;
                    text-align: right;
                }
                #text_cliente {
                    top: 700px;
                    font-size: 26px;
                    font-weight: bold;
                }
                #text_instalacion {
                }
                .etiqueta_info {
                    position: absolute;
                }
            </style>
            <script src="js/comportamiento.js"></script>
        </head>
        <body marginheight="0px" marginwidth="0px">
            <div id="pagina_exportada">
                <div class="simple" style="position: relative">';

        foreach ($datos["puntos"] as $punto) {
            $id_instalacion = $punto["id_instalacion"];
            $xCoord = $punto["x_coord"] * 0.85;
            $yCoord = $punto["y_coord"] * 0.85;
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
                '<div style="left: ' . $xCoord . 'px; top: ' . $yCoord . 'px;'.
                'width: 15px; height: 15px;" class="contenedor_punto">';
            $html_string .= '<span class="dot punto_redondo exterior" style="background-color: white;"></span>';
            /*$html_string .=
                '<span style="background-color: ' . $color_hex. '; border-radius: 50%; display: inline-block; '.
                'position: absolute; height: 19px; width: 19px; z-index: 5"></span>
                ';*/
            $html_string .= '<span class="dot punto_redondo interior" style="background-color: ' . $color_hex . ' ; right: 100px;"></span>';

            /*$html_string .= '<div style="position: absolute; left: ' . $xCoord . 'px; right: ' . $yCoord . 'px;'.
                'width: 15px; height: 15px; border-radius: 50%;">';*/
            $html_string .= '</div>
                ';

        }
        $html_string .= '<img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($datos["imagen"]).'"/>';
        $html_string .= '<span id="text_cliente" class="margen_izquierda etiqueta_info">Cliente: ' . $datos["cliente"] . ' <br> Instalación: ' . $datos["instalacion"] . '</span>';
        $html_string .= '<span id="text_instalacion" class="margen_izquierda etiqueta_info"></span>';
        $html_string .= '</div>
                </div>
            </div>
        </body>
        </html>';
        return $html_string;
    }
}