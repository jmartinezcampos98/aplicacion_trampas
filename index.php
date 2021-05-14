<html>
<head>
    <title>Herramienta de trampas</title>
    <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
    <script src="js/comportamiento.js"></script>
</head>
<body marginheight="0px" marginwidth="0px">
    <div>
        <?php
        require_once("conexion.php");
        // Comprueba si existe entrada POST
        $post_input = $_POST['select_cliente'] ?? null;
        $post_parameters = explode(':', $post_input);
        // Si carga desde borrar o insertar imagen
        if (isset($_POST["cliente"]) && isset($_POST["instalacion"])) {
            $post_cliente = $_POST["cliente"];
            $post_instalacion = $_POST["instalacion"];
        // Si carga desde "Cargar"
        } else if (count($post_parameters) == 2) {
            $post_cliente = $post_parameters[0];
            $post_instalacion = $post_parameters[1];
        // Si no tenemos información POST
        } else {
            $post_cliente = null;
            $post_instalacion = null;
        }
        /**
         * para estas pruebas sobreescribimos el post de cliente, instalación y zona
         *
         */
        $post_cliente = '115';
        $post_instalacion = '5';
        $post_zona = 'ALMACEN';
        /**
         * En la primera versión, la base de datos interna gestionaba toda la aplicación
         *
         * Ahora tan solo almacenamos la información de visualización, como la imagen y la posición
         * de los puntos en esta
         *
         * El resto tiene que venir por peticiones a la API de Trakta
         */
        // Conecta a base de datos
        /*
        $conexion = abrir_conexion();
        // Todas las instalaciones
        $consulta = $conexion->prepare("SELECT ins.cliente, ins.instalacion, ins.nombre_cliente
            FROM instalaciones ins
            ORDER BY ins.instalacion, ins.cliente");
        $consulta->execute();
        $datos_instalaciones = $consulta->fetchAll(PDO::FETCH_ASSOC);
        */
        /**
         * Lo que antes venía de la base de datos local, lo pedimos con curl de la API
         */
        // $curl_petition = curl_init('https://enlace.api/zonas');
        // curl_setopt($curl_petition, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl_petition, CURLOPT_HEADER, 0);
        /**
         * Vamos a pedir que estos datos vengan en forma de json, así que lo asumimos de esta manera
         */
        // $curl_data = curl_exec($curl_petition);
        // $datos_instalaciones = json_decode($curl_data);
        /**
         * DATOS DE EJEMPLO QUE DEBERÍAN VENIR DE LA PETICIÓN
         */
        include_once 'generador_pruebas.php';
        $curl_data = getFakeJsonString();
        $datos_mapas = json_decode($curl_data);
        /**
         */
        // curl_close($curl_petition);
        $conexion = abrir_conexion();
        // Si hay POST, intenta obtener la imagen y los puntos
        $datos_mapa = null;
        $datos_puntos = array();
        if ($post_instalacion) {
            $datos_mapa = obtener_datos_mapa($conexion, $post_cliente, $post_instalacion, $post_zona);
            if ($datos_mapa != null && $id_mapa = $datos_mapa['ID_MAPA']) {
                $datos_puntos = obtener_puntos($conexion, $id_mapa);
            }
        }
        // Dibuja la imagen
        $div_imagen = '<div class="simple" onclick="break_function()">';
        if (($imagen_bd = $datos_mapa['IMAGEN']) != null) {
            $div_imagen .= '<img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($imagen_bd).'"/>';
        } else {
            $div_imagen .= '<img class="imagen_plano" src="imagenes/no_imagen.jpeg"/>';
            $div_imagen .= '<span class="texto_imagen">No hay imagen</span>';
        }
        $div_imagen .= '</div>';
        echo($div_imagen);
        ?>
    <div/>
    <div>
        <br/>
        <form  class="margen_izquierda" action="index.php" method="POST">
            <label for="select_cliente">Elige el cliente, instalación y zona:</label>
            <select name="cliente" id="select_cliente" onchange="clienteSesion = this.value; fillInstalacionField();"></select>
            <label for="select_instalacion"></label>
            <select name="instalacion" id="select_instalacion" onchange="instalacionSesion = this.value; fillZonaField();"></select>
            <label for="select_zona"></label>
            <select name="zona" id="select_zona" onchange="zonaSesion = this.value;"></select>
            <span>&nbsp;&nbsp;&nbsp;</span>
            <input type="submit" value="Cargar">
            <script type="text/javascript">
                var datosMapas = JSON.parse('<?= $curl_data ?>');
                var clienteSesion = '<?= $post_cliente ?>'
                var instalacionSesion = '<?= $post_instalacion ?>';
                var zonaSesion = '<?= $post_zona ?>';

                // Rellena el selector de clientes
                function fillClienteField() {
                    let select = document.getElementById('select_cliente');
                    let optionsText = '<option value=""></option>';
                    for (let i = 0; i < datosMapas.length; i++) {
                        optionsText += '<option value="' + datosMapas[i]['cliente'] + '"';
                        if (clienteSesion === datosMapas[i]['cliente']) {
                            optionsText += 'selected="selected"';
                        }
                        optionsText += '>' + datosMapas[i]['cliente'] + '</option>';
                    }
                    select.innerHTML = optionsText;
                    clienteSesion = select.value;
                    fillInstalacionField();
                }

                // Rellena el selector de instalaciones
                function fillInstalacionField() {
                    let select = document.getElementById('select_instalacion');
                    let optionsText = '<option value=""></option>';
                    if (clienteSesion != null && clienteSesion !== '') {
                        try {
                            let clienteIndex;
                            for (let i = 0; i < datosMapas.length; i++) {
                                if (datosMapas[i]['cliente'] === clienteSesion) {
                                    clienteIndex = i;
                                }
                            }
                            let datosInstalaciones = datosMapas[clienteIndex]['instalaciones'];
                            for (let i = 0; i < datosInstalaciones.length; i++) {
                                optionsText += '<option value="' + datosInstalaciones[i]['instalacion'] + '"';
                                if (instalacionSesion === datosInstalaciones[i]['instalacion']) {
                                    optionsText += 'selected="selected"';
                                }
                                optionsText += '>' + datosInstalaciones[i]['instalacion'] + '</option>';
                            }
                        } catch (e) {

                        }
                    }
                    select.innerHTML = optionsText;
                    instalacionSesion = select.value;
                    fillZonaField();
                }

                // Rellena el selector de zonas
                function fillZonaField() {
                    let select = document.getElementById('select_zona');
                    let optionsText = '<option value=""></option>';
                    if (instalacionSesion != null && instalacionSesion !== '') {
                        try {
                            let clienteIndex;
                            for (let i = 0; i < datosMapas.length; i++) {
                                if (datosMapas[i]['cliente'] === clienteSesion) {
                                    clienteIndex = i;
                                }
                            }
                            let datosInstalaciones = datosMapas[clienteIndex]['instalaciones'];
                            let instalacionIndex;
                            for (let i = 0; i < datosInstalaciones.length; i++) {
                                if (datosInstalaciones[i]['instalacion'] === instalacionSesion) {
                                    instalacionIndex = i;
                                }
                            }
                            let datosZonas = datosInstalaciones[instalacionIndex]['zonas'];
                            for (let i = 0; i < datosZonas.length; i++) {
                                optionsText += '<option value="' + datosZonas[i]['zona'] + '"';
                                if (zonaSesion === datosZonas[i]['zona']) {
                                    optionsText += 'selected="selected"';
                                }
                                optionsText += '>' + datosZonas[i]['zona'] + '</option>';
                            }
                        } catch (e) {

                        }
                    }
                    select.innerHTML = optionsText;
                    zonaSesion = select.value;
                }

                fillClienteField();
            </script>
            <script>
                function break_function() {
                    console.log('hello!');
                }
            </script>
        </form>

        <?php
        /*
        // Si se ha indicado un cliente e instalacion a través de POST
        if ($post_id_cliente != null && $post_id_instalacion != null) {
            // Si la instalación en cuestión tiene una imagen vinculada
            if ($datos_mapa) {
                echo('<span class="margen_izquierda"><b>Puede actualizar la imagen de la instalacion ' . $post_id_instalacion . ' a partir de un fichero en su equipo.</b></span>');
            } else {
                echo('<span class="margen_izquierda"><b>No existe imagen en base de datos. Puede insertarla a partir de un fichero en su equipo.</b></span>');
            }
            echo('
                <form class="margen_izquierda" action="guardar_imagen.php" method="POST" enctype="multipart/form-data">
                    <input type="file" required name="imagen"/>
                    <input type="hidden" name="cliente" value="' . $post_id_cliente . '"/>
                    <input type="hidden" name="instalacion" value="' . $post_id_instalacion . '"/>
                    <input type="submit" value="Actualizar imagen"/>
                </form>');
            // Si hay imagen vinculada, se puede borrar
            if ($datos_mapa) {
                echo('
                    <form class="margen_izquierda" action="borrar_imagen.php" method="POST">
                        <label>Puede borrar la imagen actual pulsando este botón:</label>
                        <input type="hidden" name="cliente" value="' . $post_id_cliente . '"/>
                        <input type="hidden" name="instalacion" value="' . $post_id_instalacion . '"/>
                        <input type="submit" value="Borrar imagen de instalación" 
                            onclick="return confirm(' . addslashes("Si borras la imagen, se borrarán también los puntos asignados a esta.") . ')"/>
                    </form>');
            }
        }
        ?>
        <?php
        if ($datos_mapa) {
            echo('
                <div class="margen_izquierda">
                    <button onclick="guardarPuntos()">Guardar estado puntos</button> <span id="estadoGuardar"></span>
                    <form class="margen_arriba" action="pagina_exportar_pdf.php" method="POST">
                        <input type="hidden" name="cliente" value="' . $post_id_cliente . '"/>
                        <input type="hidden" name="nombre_cliente" value="' . $input_nombre_cliente . '"/>
                        <input type="hidden" name="instalacion" value="' . $post_id_instalacion . '"/>
                        <input type="submit" value="Exportar PDF">
                    </form>
                    
                </div>
            ');
        }*/
        ?>

    </div>
    <div id="puntosPantalla">
    </div>
    <div id="inicializacionPuntos">
        <?php
        /*
        if ($datos_mapa) {
            foreach ($datos_puntos as $punto) {
                $id_instalacion = $punto["instalacion"];
                $xCoord = $punto["x_coord"];
                $yCoord = $punto["y_coord"];
                $color_dato = $punto["color"];
                switch ($color_dato) {
                    case 0:
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
                echo ('<script type="text/javascript"> crear('
                    . $xCoord . ', ' . $yCoord . ', "'
                    . $color_hex . '", "' . $nombre . '", "' . $id_instalacion
                    . '"); </script>');
            }
        }
        */
        ?>
    </div>
</body>
</html>