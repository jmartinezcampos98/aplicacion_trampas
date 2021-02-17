<html>
<head>
    <title>Herramienta de trampas</title>
    <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
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

            //if ($imagen_descargada) {
            if (false) {
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
                $xCoord = $punto["xCoord"];
                $yCoord = $punto["yCoord"];
                $color = $punto["color"];
                $nombre = $punto["nombre"];
                echo('<div>');
                echo('<span class="dot punto_redondo" style="background-color: ' . $color . ';top: ' . $yCoord . 'px;left: ' . $xCoord . 'px;"></span>');
                echo('<tag class="puntos" style="top:' . $yCoord . 'px; left: ' . $xCoord + 15 . 'px;">' . $nombre . '</tag>');
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
        <button>Actualizar puntos</button>


    </div>

    <input id='input_x' style="width: 50px; height:20px;"> </input>
    <input id="input_y" style="width: 50px; height:20px;"> </input>


</body>
</html>