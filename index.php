<html>
<head>
    <title>Herramienta de trampas</title>
    <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
    <script src="js/comportamiento.js"></script>
</head>
<body marginheight="0px" marginwidth="0px">
    <div>
        <?php
            include("conexion.php");
            $conexion_imagenes = abrir_conexion();
            $id_instalacion_configurada = 'BODEGA_VEGAMAR_BAJO';
            $query = "SELECT * FROM IMAGENES WHERE ID_INSTALACION = '$id_instalacion_configurada'";
            $resultado_consulta = $conexion_imagenes->query($query);
            $imagen_descargada = $resultado_consulta->fetch_assoc();

            if ($imagen_descargada) {
                echo ('<img class="imagen_plano" src="data:image/jpg;base64,'.base64_encode($imagen_descargada['IMAGEN']).'"/>');
            } else {
                echo ('<img class="imagen_plano" src="imagenes/trampas_default.jpeg"/>');
            }
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
        ?>
        <form action="proceso_guardar.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del usuario" value=""/>
            <input type="text" required name="id_instalacion" placeholder="Nombre de instalación" value=""/>
            <input type="file" required name="imagen"/>
            <input type="submit" value="Aceptar"/>
        </form>



        <button onclick="crear()">Crear punto</button>


        <button>Actualizar BD</button>
        <button>Exportar PDF</button>
    </div>

</body>
</html>