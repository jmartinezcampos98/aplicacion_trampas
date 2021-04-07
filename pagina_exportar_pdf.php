<html>
<head>
    <title>Herramienta de trampas</title>
    <link rel="stylesheet" type="text/css" href="estilos/estilos.css" media="screen">
    <script src="js/comportamiento.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
    </script>
</head>
<body marginheight="0px" marginwidth="0px">
    <div class="margen_arriba">
        <?php

        include("conexion.php");

        // Conecta a base de datos
        $conexion_datos = abrir_conexion();
        // Obtiene las variables del formulario
        $input_id_cliente = $_POST['id_cliente'];
        $input_nombre_cliente = $_POST['nombre_cliente'];
        $input_instalacion = $_POST['id_instalacion'];

        echo(
            '<form class="margen_izquierda" action="index.php" method="POST">
                <input type="hidden" name="id_cliente" value="' . $input_id_cliente . '"/>
                <input type="hidden" name="id_instalacion" value="' . $input_instalacion . '"/>
                <input type="submit" value="Volver a panel de control"/>
            </form>'
        );

        echo('<h3 class="margen_izquierda">Cliente e instalación a exportar: ' . $input_nombre_cliente . ', ' . $input_instalacion . '</h3>');

        $fecha_actual = getdate();
        $dia = $fecha_actual["mday"];
        $mes = $fecha_actual["mon"];
        $anyo = $fecha_actual["year"];

        echo(
            '<form id="input_fechas" class="margen_izquierda" action="accion_imprimir.php" method="POST" target="_blank">
                <div class="margen_abajo">
                    <div class="margen_abajo">
                        <label>Fecha de inicio</label>
                    </div>
                    <label for="dia_inicio">Día: </label>
                    <input id="dia_inicio" required type="text" name="dia_inicio" maxlength="2" class="fecha" value="' . $dia . '"/>
                    <label for="mes_inicio">Mes: </label>
                    <input id="mes_inicio" required type="text" name="mes_inicio" maxlength="2" class="fecha" value="'. $mes . '"/>
                    <label for="anyo_inicio">Año: </label>
                    <input id="anyo_inicio" required type="text" name="anyo_inicio" maxlength="4" class="fecha" value="'. $anyo . '"/>
                </div>
                <div class="margen_arriba margen_abajo">
                    <div class="margen_abajo">
                        <label class="margen_abajo">Fecha de fin</label>
                    </div>
                    <label for="dia_fin">Día: </label>
                    <input id="dia_fin" required type="text" name="dia_fin" maxlength="2" class="fecha" value="'. $dia . '"/>
                    <label for="mes_fin">Mes: </label>
                    <input id="mes_fin" required type="text" name="mes_fin" maxlength="2" class="fecha" value="'. $mes . '"/>
                    <label for="anyo_fin">Año: </label>
                    <input id="anyo_fin" required type="text" name="anyo_fin" maxlength="4" class="fecha" value="'. $anyo . '"/>
                </div>
                <input type="hidden" name="id_cliente" value="' . $input_id_cliente . '"/>
                <input type="hidden" name="id_instalacion" value="' . $input_instalacion . '"/>
                <input type="hidden" name="nombre_cliente" value="' . $input_nombre_cliente . '"/>
                <input class="margen_arriba" id="generar_pdf" required type="submit" value="Generar PDF">
            </form>
            <button id="redirectButton" class="margen_izquierda">Previsualizar</button>
            <script>
                document.getElementById("dia_inicio").onkeypress = validateNumber;
                document.getElementById("mes_inicio").onkeypress = validateNumber;
                document.getElementById("anyo_inicio").onkeypress = validateNumber;
                document.getElementById("dia_fin").onkeypress = validateNumber;
                document.getElementById("mes_fin").onkeypress = validateNumber;
                document.getElementById("anyo_fin").onkeypress = validateNumber;
            </script>
            <script>
                document.getElementById("redirectButton").onclick = function () {
                    window.location.href = \'previsualizar.php\';
                }
            </script>
            '
        );
        ?>
        <script>
            $('#input_fechas').submit(function() {
                const fechaInicio = $('#anyo_inicio').val() + "/" + $('#mes_inicio').val() + "/" + $('#dia_inicio').val();
                const fechaFin = $('#anyo_fin').val() + "/" + $('#mes_fin').val() + "/" + $('#dia_fin').val();
                let formatoInicioCorrecto = validDateFormat(fechaInicio);
                let formatoFinCorrecto = validDateFormat(fechaFin);
                if (!formatoInicioCorrecto) {
                    alert('La fecha de inicio se ha indicado con formato incorrecto');
                }
                if (!formatoFinCorrecto) {
                    alert('La fecha de fin se ha indicado con formato incorrecto');
                }
                if (formatoInicioCorrecto && formatoFinCorrecto) {
                    if (fechaInicio <= fechaFin) {
                        return true;
                    } else {
                        alert('La fecha de inicio no puede ser posterior a la fecha de fin');
                    }
                }
                return false;
            });
        </script>
    </div>
</body>
</html>