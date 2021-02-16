<html>
<head>
    <title>Herramienta de trampas</title>
</head>
<body marginheight="0px" marginwidth="0px">
    <div>
        <img src="trampas_default.jpeg"/>
        <div/>
        <?php
            $xml = simplexml_load_file('datos_puntos.xml');
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
        ?>

        <br/>

        <?php
            foreach ($array["punto"] as $punto) {
                $xCoord = $punto["coordX"];
                $yCoord = $punto["coordY"];
                $color = $punto["color"];
                ?>
                <span class="dot" style="height: 25px; width: 25px; background-color: <?= $color ?>; border-radius: 50%; display: inline-block;
            position: fixed; top: <?= $yCoord ?>px; left: <?= $xCoord ?>px; "></span>
                <?php
            }
        ?>
    </div>
    <div style="display: grid; grid-template-columns: 250px 200px">
        <div style="grid-column: 1">
            <form id="form" action="/action_page.php">
                <div id="form1">

                    <br>
                </div>
                <br>
            </form>

            <h3>un texto</h3>

            <button onclick="comprobar()">Actualizar</button>

        </div>
    </div>
    <button>Mostrar/Ocultar</button>
    <button onclick="crear()">Crear punto</button>
    <br>
    <input type='file' onchange="readURL(this);" />
    <br>

    <input id='input_x' style="width: 50px; height:20px;"> </input>
    <input id="input_y" style="width: 50px; height:20px;"> </input>


</body>
</html>