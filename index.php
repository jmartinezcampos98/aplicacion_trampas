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
        $input_post = isset($_POST['cliente']) ? $_POST['cliente'] : null;
        $post_inputs = explode(':', $input_post);
        // Si carga desde borrar o insertar
        if (isset($_POST["id_cliente"]) && isset($_POST["id_instalacion"])) {
            $input_id_cliente = $_POST["id_cliente"];
            $input_id_instalacion = $_POST["id_instalacion"];
        // Si carga desde "Recargar"
        } else if (count($post_inputs) == 2) {
            $input_id_cliente = $post_inputs[0];
            $input_id_instalacion = $post_inputs[1];
        // Si no tenemos información POST
        } else {
            $input_id_cliente = null;
            $input_id_instalacion = null;
        }
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
            //
            $instalacion = array(
                "id_instalacion" => $datos_instalaciones[$i]["id_instalacion"],
                "id_cliente" => $datos_instalaciones[$i]["id_cliente"],
                "nombre_cliente" => $datos_instalaciones[$i]["nombre_cliente"],
            );

            array_push($instalaciones, $instalacion);
        }
        // Si hay POST, intenta obtener la imagen y los puntos
        $dato_imagen = null;
        $datos_puntos = array();
        if ($input_id_instalacion) {
            $dato_imagen = obtener_imagen($conexion, $input_id_instalacion);
            $datos_puntos = obtener_puntos($conexion, $input_id_instalacion);
        }
        // Dibuja la imagen
        $div_imagen = '<div class="simple">';
        if ($dato_imagen) {
            $div_imagen .= '<img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($dato_imagen).'"/>';
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
        // Carga los datos escritos en xml
        $xml = simplexml_load_file('datos_puntos.xml');
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        ?>
        <br/>

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
        // Si se ha indicado un cliente e instalacion a través de POST
        if ($input_id_cliente != null && $input_id_instalacion != null) {
            // Si la instalación en cuestión tiene una imagen vinculada
            if ($dato_imagen) {
                echo('<span class="margen_izquierda"><b>Puede actualizar la imagen de la instalacion ' . $input_id_instalacion . ' a partir de un fichero en su equipo.</b></span>');
            } else {
                echo('<span class="margen_izquierda"><b>No existe imagen en base de datos. Puede insertarla a partir de un fichero en su equipo.</b></span>');
            }
            echo('
                <form class="margen_izquierda" action="proceso_guardar.php" method="POST" enctype="multipart/form-data">
                    <input type="file" required name="imagen"/>
                    <input type="hidden" name="id_cliente" value="' . $input_id_cliente . '"/>
                    <input type="hidden" name="id_instalacion" value="' . $input_id_instalacion . '"/>
                    <input type="submit" value="Aceptar"/>
                </form>');
            // Si hay imagen vinculada, se puede borrar
            if ($dato_imagen) {
                echo('
                    <form class="margen_izquierda" action="proceso_borrar.php" method="POST">
                        <label>Puedes borrar la imagen actual pulsando este botón:</label>
                        <input type="hidden" name="id_cliente" value="' . $input_id_cliente . '"/>
                        <input type="hidden" name="id_instalacion" value="' . $input_id_instalacion . '"/>
                        <input type="submit" value="Borrar imagen de instalación" 
                            onclick="return confirm(' . addslashes("Si borras la imagen, se borrarán también los puntos asignados a esta.") . ')"/>
                    </form>');
            }
        }
        ?>
        <?php
        if ($dato_imagen) {
            echo('
                <div class="margen_izquierda">
                    <button onclick="crearVacio(\'' . $input_id_instalacion . '\')">Crear punto</button>
                    <button onclick="guardarPuntos()">Guardar estado</button> <span id="estadoGuardar"></span>
                    </br><button style="margin-top: 5px">Exportar PDF</button>
                </div>
            ');
        }
        ?>

    </div>
    <div id="puntosPantalla">

    </div>
    <div>
        <?php
        if ($input_id_instalacion) {

            foreach ($datos_puntos as $punto) {
                $id_instalacion = $punto["id_instalacion"];
                $xCoord = $punto["x_coord"];
                $yCoord = $punto["y_coord"];
                $color = $punto["color"];
                $nombre = $punto["lugar"];
                echo ('<script type="text/javascript"> crear('
                    . $xCoord . ', ' . $yCoord . ', "'
                    . $color . '", "' . $nombre . '", "' . $id_instalacion
                    . '"); </script>');
            }
        }
        ?>
    </div>
</body>
</html>