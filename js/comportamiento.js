

var mousePosition;
var offset = [0,0];
var div;
var tagElements = [];
var tagFlags = [];
var cont = 0;
var coordPuntos = []
var puntoSeleccionado = null;

function crearVacio(id_mapa) {
    crear(0, 0, "red", "Almacén", id_mapa, "");
}

function crear(left, top, color, name, id_mapa, tipo_punto){

    // var nuevo = document.getElementById("puntosPantalla").appendChild("div");

    var divTodosLosPuntos = document.getElementById("puntosPantalla");
    var divPunto = document.createElement("div");


    divPunto.id="d"+cont;
    divPunto.style.position = "absolute";
    divPunto.style.left = left + "px";
    divPunto.style.top = top + "px";
    divPunto.style.width = "15px";
    divPunto.style.height = "15px";
    divPunto.style.color = "blue";
    divPunto.className=cont;

    var isDown = false;
    tagFlags.push(isDown);

    divPunto.innerHTML =
        '<span class="dot punto_redondo exterior" style="background-color: white;"></span>'
        + '<span class="dot punto_redondo interior" style="background-color: ' + color + ';"></span>'
        + '<span class="texto_puntos">' + name + '</span>'
    ;

    divTodosLosPuntos.appendChild(divPunto);

    coordPuntos.push({
        x : left,
        y : top,
        color : color,
        name : name,
        number : cont,
        id_mapa : id_mapa,
        tipo_punto: tipo_punto
    });

    tagElements.push(divPunto);
    cont++;

    divPunto.addEventListener('mousedown', function(e) {
        tagFlags[divPunto.className] = true;
        //
        puntoSeleccionado = divPunto;
        //
        offset = [
            divPunto.offsetLeft - e.clientX,
            divPunto.offsetTop - e.clientY
        ];

    }, true);
}

document.addEventListener('mouseup', function(event) {
    var i;
    for (i = 0; i < tagFlags.length; i++) {
        if (tagFlags[i]) {
            coordPuntos[i].x = event.clientX + offset[0];
            coordPuntos[i].y = event.clientY + offset[1];
        }
        tagFlags[i]=false;
    }
}, true);

document.addEventListener('mousemove', function(event) {
    event.preventDefault();
    var i=0;
    for (i = 0; i < tagFlags.length; i++) {
        if (tagFlags[i]) {

            mousePosition = {

                x : event.clientX,
                y : event.clientY

            };

            tagElements[i].style.left = (mousePosition.x + offset[0]) + 'px';
            tagElements[i].style.top  = (mousePosition.y + offset[1]) + 'px';
        }
    }
}, true);

function guardarPuntos() {
    let cadenaEnvio = "";
    let puntos = [];
    let id_mapa;
    for (i = 0; i < coordPuntos.length; i++) {
        // orden de parametros -> $num_punto, $id_instalacion, $x_coord, $y_coord, $lugar, $color
        cadenaEnvio += (coordPuntos[i].number + ":" + coordPuntos[i].id_mapa + ":" + coordPuntos[i].x + ":" + coordPuntos[i].y + ":" + coordPuntos[i].name);
        id_mapa = coordPuntos[i].id_mapa;
        puntos.push({
            'num_punto': coordPuntos[i].number,
            'tipo': coordPuntos[i].tipo_punto,
            'nombre': coordPuntos[i].name,
            'x_coord': coordPuntos[i].x,
            'y_coord': coordPuntos[i].y,
        });

        // Si no es el último punto, añade uno más
        if (i !== coordPuntos.length - 1) {
            cadenaEnvio += "+";
        }
    }
    /*
    $.post('ajax.php',
        {puntos: puntos},
        function (data, status) {
            const date = new Date();
            document.getElementById("estadoGuardar").innerHTML = this.responseText + ", a las "
                + date.getHours() + "h " + date.getMinutes() + "min " + date.getSeconds() + "s ";
        }
    );
    */

    function printResult(responseText) {
        const date = new Date();
        document.getElementById("estadoGuardar").innerHTML = responseText + ", a las "
            + date.getHours() + "h " + date.getMinutes() + "min " + date.getSeconds() + "s ";
    }

    $.ajax({
        type: 'POST',
        url: '/aplicacion_trampas/ajax.php',
        data: {id_mapa: id_mapa, puntos: puntos},
        dataType: 'json',
        success: function (result, status, xhr) {
            printResult(result['message']);
        },
        error: function (xhr,status,error) {
            printResult('Error guardando puntos');
            console.log('Error de AJAX guardando puntos');
        },
    });
/*
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const date = new Date();
            document.getElementById("estadoGuardar").innerHTML = this.responseText + ", a las "
                + date.getHours() + "h " + date.getMinutes() + "min " + date.getSeconds() + "s ";
        }
    }
    xhttp.open("GET", "ajax.php?q=" + encodeURIComponent(cadenaEnvio), true);
    xhttp.send();

 */
}

function validDateFormat(dateVal){

    if (dateVal == null) {
        return false;
    }

    const validatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;

    let dateValues = dateVal.match(validatePattern);

    if (dateValues == null) {
        return false;
    }

    const dtYear = Number(dateValues[1]);
    let dtMonth = Number(dateValues[3]);
    let dtDay = Number(dateValues[5]);

    if (dtMonth < 1 || dtMonth > 12) {
        return false;
    } else if (dtDay < 1 || dtDay> 31) {
        return false;
    } else if ((dtMonth===4 || dtMonth===6 || dtMonth===9 || dtMonth===11) && dtDay ===31) {
        return false;
    } else if (dtMonth === 2) {
        const isleap = (dtYear % 4 === 0 && (dtYear % 100 !== 0 || dtYear % 400 === 0));
        if (dtDay> 29 || (dtDay ===29 && !isleap))
            return false;
    }

    return true;
}

function validateNumber(event) {
    const theEvent = event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}