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
        $instalacion_seleccionada = isset($_POST['cliente_instalacion']) ? $_POST['cliente_instalacion'] : null;
        $parametros_post = explode(':', $instalacion_seleccionada);
        // Si carga desde borrar o insertar imagen
        if (isset($_POST["id_cliente"]) && isset($_POST["id_instalacion"])) {
            $input_id_cliente = $_POST["id_cliente"];
            $input_id_instalacion = $_POST["id_instalacion"];
        // Si carga desde crear instalacion
        } else if (isset($_POST["nombre_cliente_creado"]) && isset($_POST["id_cliente_creado"]) && isset($_POST["instalacion_creada"])) {
            $input_id_cliente = $_POST["id_cliente_creado"];
            $input_id_instalacion = $_POST["instalacion_creada"];
        // Si carga desde "Cargar"
        } else if (count($parametros_post) == 2) {
            $input_id_cliente = $parametros_post[0];
            $input_id_instalacion = $parametros_post[1];
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

        <form class="margen_izquierda" action="index.php" method="POST">
            <label for="cliente_instalacion">Elige el cliente y la instalación:</label>
            <select name="cliente_instalacion" id="cliente_instalacion">
                <?php
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
            <input type="submit" value="Cargar">
        </form>

        <form class="margen_izquierda" action="crear_instalacion.php" method="POST">
            <label >Crea nueva instalación</label><input class="margen_izquierda" type="submit" value="Crear">
            <div style="height: 8px"></div>
            <label for="nombre_cliente_creado">Nombre cliente:</label>
            <input required type="text" name="nombre_cliente_creado" value="" size="60" maxlength="50" style="left: 110px; position: absolute"/>
            <div style="height: 8px"></div>
            <label for="id_cliente_creado">Id. cliente:</label>
            <input required type="text" name="id_cliente_creado" value="" size="60" maxlength="50" style="left: 110px; position: absolute"/>
            <div style="height: 8px"></div>
            <label for="instalacion_creada">Instalación:</label>
            <input required type="text" name="instalacion_creada" value="" size="60" maxlength="50" style="left: 110px; position: absolute"/>
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
                <form class="margen_izquierda" action="guardar_imagen.php" method="POST" enctype="multipart/form-data">
                    <input type="file" required name="imagen"/>
                    <input type="hidden" name="id_cliente" value="' . $input_id_cliente . '"/>
                    <input type="hidden" name="id_instalacion" value="' . $input_id_instalacion . '"/>
                    <input type="submit" value="Aceptar"/>
                </form>');
            // Si hay imagen vinculada, se puede borrar
            if ($dato_imagen) {
                echo('
                    <form class="margen_izquierda" action="borrar_imagen.php" method="POST">
                        <label>Puede borrar la imagen actual pulsando este botón:</label>
                        <input type="hidden" name="id_cliente" value="' . $input_id_cliente . '"/>
                        <input type="hidden" name="id_instalacion" value="' . $input_id_instalacion . '"/>
                        <input type="submit" value="Borrar imagen de instalación" 
                            onclick="return confirm(' . addslashes("Si borras la imagen, se borrarán también los puntos asignados a esta.") . ')"/>
                    </form>');
            }
            echo('
                <form class="margen_izquierda" action="borrar_instalacion.php" method="POST">
                    <label>Puede borrar la instalación actual pulsando este botón:</label>
                    <input type="hidden" name="id_cliente_borrado" value="' . $input_id_cliente . '"/>
                    <input type="hidden" name="instalacion_borrada" value="' . $input_id_instalacion . '"/>
                    <input type="submit" value="BORRAR INSTALACIÓN"
                        onclick="return confirm(' . addslashes("SE BORRARÁN TODOS LOS DATOS DE ESTA INSTALACIÓN.") . ')"/>
                </form>');
        }
        ?>
        <?php
        if ($dato_imagen) {
            echo('
                <div class="margen_izquierda">
                    <button onclick="crearVacio(\'' . $input_id_instalacion . '\')">Crear punto</button>
                    <button onclick="guardarPuntos()">Guardar estado</button> <span id="estadoGuardar"></span>
                    </br></br><form class="margen_arriba">
                        <label for="coordenadaX">Coord X</label>
                        <input disabled type="text" name="coordenadaX" value="" size="5"/>
                        <label for="coordenadaY" style="position:relative; left: 20px;">Coord Y</label>
                        <input disabled type="text" name="coordenadaY" value="" style="position:relative; left: 20px;" size="5"/>
                        </br></br>
                        <label for="lugar">Lugar</label>
                        <input type="text" name="lugar" value="" size="30" maxlength="30"/>
                        </br></br>
                        <label for="color">Color</label>
                        <select name="color" id="seleccionableColor" onchange="cambiarColor()">
                            <option disabled selected="selected" value=""></option>
                            <option value="#008000">Verde</option>
                            <option value="#ffff00">Amarillo</option>
                            <option value="#ff0000">Rojo</option>
                        </select>
                    </form>
                    <button disabled onclick="eliminarPunto()" >ELIMINAR PUNTO</button>
                    </br></br><button style="margin-top: 5px">Exportar PDF</button>
                </div>
            ');
        }
        ?>

    </div>
    <div id="puntosPantalla">
    </div>
    <div id="inicializacionPuntos">
        <?php
        if ($dato_imagen) {
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