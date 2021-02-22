

var mousePosition;
var offset = [0,0];
var div;
var tagLabels = [];
var tagElements = [];
var tagFlags = [];
var cont = 0;
var vectorInputs = [];
var vectorInputsName = [];
var coordPuntos = []
var puntoSeleccionado = null;

function crearVacio(instalacion) {
    crear(0, 0, "red", "Almacén", instalacion);
}

function crear(left, top, color, name, instalacion){

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
        instalacion : instalacion
    });

    tagElements.push(divPunto);
    cont++;

    divPunto.addEventListener('mousedown', function(e) {
        tagFlags[divPunto.className] = true;
        //tagFlags.push(true);

        //
        puntoSeleccionado = divPunto;
        // boton eliminar punto deja de estar desactivado
        // actualiza parametros
        // seleccionar lista color y activarla

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
            // x_input.value = (mousePosition.x + offset[0]) + 'px';
            // y_input.value = (mousePosition.y + offset[1]) + 'px';

            // tagLabels[i].style.left = (mousePosition.x + offset[0]) + 'px';
            // tagLabels[i].style.top  = (mousePosition.y + offset[1] - 20) + 'px';
        }
    }
}, true);

function actualizaParametrosPunto() {
    // cambia texto coordX
    // cambia texto coordY
    // cambia texto lugar
    // cambia seleccionable option color
}

function eliminarPunto() {
    puntoSeleccionado = null;
    // seleccionar boton eliminar y desactivarlo
    // seleccionar lista color y desactivarla
    // enviar orden para borrar de base de datos
    // actualizar el html para quitarlo
    // actualiza parametros
}

function cambiarColor() {
    // actualiza el color del punto seleccionado
}

function guardarPuntos() {
    let cadenaEnvio = "";
    for (i = 0; i < coordPuntos.length; i++) {
        // orden de parametros -> $num_punto, $id_instalacion, $x_coord, $y_coord, $lugar, $color
        cadenaEnvio += (coordPuntos[i].number + ":" + coordPuntos[i].instalacion + ":" + coordPuntos[i].x + ":" + coordPuntos[i].y + ":" + coordPuntos[i].name + ":" + coordPuntos[i].color);
        // Si no es el último punto, añade uno más
        if (i !== coordPuntos.length - 1) {
            cadenaEnvio += "+";
        }
    }

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