<html>
<head>
    <title>Herramienta de trampas</title>
    <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
    <script src="js/comportamiento.js"></script>
</head>
<body marginheight="0px" marginwidth="0px">
    <div>
        <?php
        // Comprueba si existe entrada POST
        //
        $input_id_instalacion = "BODEGAS_VEGAMAR_BAJO";
        $input_id_cliente = "12345678Z";
        //
        // Conecta a base de datos
        require_once("conexion.php");
        $conexion = abrir_conexion();
        // Todas las instalaciones
        $consulta = $conexion->prepare("SELECT ins.id_cliente, ins.id_instalacion, ins.nombre_cliente
            FROM instalaciones ins
            ORDER BY ins.id_instalacion, ins.id_cliente");
        $consulta->execute();
        $datos_instalaciones = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $instalaciones = array();

        for ($i = 0; $i < count($datos_instalaciones); $i++) {
            // $datos_puntos = obtener_puntos($datos_instalaciones[$i]["id_instalacion"]);
            // $dato_imagen = obtener_imagen($datos_instalaciones[$i]["id_instalacion"]);

            $instalacion = array(
                "id_instalacion" => $datos_instalaciones[$i]["id_instalacion"],
                "id_cliente" => $datos_instalaciones[$i]["id_cliente"],
                "nombre_cliente" => $datos_instalaciones[$i]["nombre_cliente"],
            );

            array_push($instalaciones, $instalacion);
        }
        // Si hay post intenta obtener la imagen
        $dato_imagen = null;
        $datos_puntos = array();
        if ($input_id_instalacion) {
            $dato_imagen = obtener_imagen($conexion, $input_id_instalacion);
            $datos_puntos = obtener_puntos($conexion, $input_id_instalacion);
        }
        //
        $div_imagen = '<div class="simple">';
        if ($dato_imagen) {
            $div_imagen .= '<img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($dato_imagen['imagen']).'"/>';
        } else {
            $div_imagen .= '<img class="imagen_plano" src="imagenes/no_imagen.jpeg"/>';
            $div_imagen .= '<span class="texto_imagen">No hay imagen</span>';
        }
        $div_imagen .= '</div>';
        echo($div_imagen);
        ?>
    <div/>
    <div>
        <?php
            $xml = simplexml_load_file('datos_puntos.xml');
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
        ?>

        <br/>

        <?php
        /*
            foreach ($array["punto"] as $punto) {
                $identificador = $id_instalacion_configurada . ':' . $punto["@attributes"]["id"];
                $xCoord = $punto["xCoord"];
                $yCoord = $punto["yCoord"];
                $color = $punto["color"];
                $nombre = $punto["nombre"];
                echo('<div id="' . $identificador . '" style="position: absolute; top:' . $yCoord . 'px; left: ' . ($xCoord + 15) . 'px;">');
                echo('<span class="dot punto_redondo" style="background-color: ' . $color . ';"></span>');
                echo('<span class="texto_puntos">' . $nombre . '</span>');
                echo('</div>');
            }
        */
        ?>
        <form action="index.php" method="POST">
            <span>&nbsp;&nbsp;&nbsp;</span><label for="cliente">Elige el cliente y la instalación:</label>
            <select name="cliente" id="cliente">
                <?php
                // falta hacer que se seleccione por defecto la que venía
                if ($input_id_instalacion) {
                    echo('<option value=""></option>');
                } else {
                    echo('<option value="" selected="selected"></option>');
                }
                for ($i = 0; $i < count($datos_instalaciones); $i++) {
                    $option_echo = '<option ';
                    if ($input_id_instalacion == $datos_instalaciones[$i]["id_instalacion"] &&
                        $input_id_cliente == $datos_instalaciones[$i]["id_cliente"]) {
                        $option_echo .= ' selected="selected" ';
                    }
                    $option_echo .= ('value="' .
                        $datos_instalaciones[$i]["id_cliente"] . ':' . $datos_instalaciones[$i]["id_instalacion"] . '">'
                        . $datos_instalaciones[$i]["nombre_cliente"] . ', ' . $datos_instalaciones[$i]["id_instalacion"] . '</option>');
                    echo($option_echo);
                }
                ?>
            </select><span>&nbsp;&nbsp;&nbsp;</span>
            <input type="submit" value="Recargar">
        </form>

        <?php
        if ($dato_imagen) {
            echo('<span class="margen_izquierda"><b>Puede actualizar la imagen de la instalacion ' . $input_id_instalacion . ' a partir de un fichero en su equipo.</b></span>');
        } else {
            echo('<span class="margen_izquierda"><b>No existe imagen en base de datos. Puede insertarla a partir de un fichero en su equipo.</b></span>');
        }
        ?>
        <form class="margen_izquierda" action="proceso_guardar.php" method="POST" enctype="multipart/form-data">
            <input type="file" required name="imagen"/>
            <input type="hidden" name="id_cliente" value="<?= $input_id_cliente ?>"/>
            <input type="hidden" name="id_instalacion" value="<?= $input_id_instalacion ?>"/>
            <input type="submit" value="Aceptar"/>
        </form>

        <?php
        if ($dato_imagen) {
            echo('
                <div class="margen_izquierda">
                    <button onclick="crear()">Crear punto</button>
                    <button>Actualizar BD</button>
                    <button>Exportar PDF</button>
                </div>
            ');
        }
        ?>

    </div>

</body>
</html>