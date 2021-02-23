<?php


class ImpresionTrampas
{



    public function parsePagina(array $datos): string
    {
        echo $datos;
        /*
        return '<html>
        <head>
            <title>Herramienta de trampas</title>
            <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
            <script src="js/comportamiento.js"></script>
        </head>
        <body marginheight="0px" marginwidth="0px">
            <div>
                <div class="simple">'.
                    //<img class="imagen_plano" <img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($datos["imagen"]).'"/>
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
        </body>
        </html>';*/
        return '<html>
        <head>
        </head>
        <body>
            <div>
                <div>
                    <br/>
                    <div >
                        <h2>Cliente: </h2>
                    </div>
                    <!-- AQUI LOS PUNTOS -->
                </div>
            </div>
        </body>
        </html>';
    }
}